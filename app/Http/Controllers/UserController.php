<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('users.index', ['users' => User::all()]);
    }

    /**
     * Show the form for creating a new user.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('users.form', ['user' => new User]);
    }

    /**
     * Store a newly created user in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $attributes = $request->except(['_token', 'picture', 'password']);

        if ($request->hasFile('picture')) {
            $uploadedFile              = $request->file('picture');
            $path                      = $uploadedFile->storePublicly('public/users');
            $attributes['picture_url'] = $path;
        }

        if ($request->get('password') !== '') {
            $attributes['password'] = $request->input('password');
        }

        $attributes['is_admin'] = $request->has('is_admin');

        $user = User::create($attributes);

        return redirect()->route('universes.edit', $user)
            ->with('success', 'User successfully created!');
    }

    /**
     * Show the form for editing the specified user.
     *
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('users.form', ['user' => $user]);
    }

    /**
     * Update the specified user in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $attributes = $request->except(['_token', 'picture', 'password']);

        if ($request->hasFile('picture')) {
            $uploadedFile              = $request->file('picture');
            $path                      = $uploadedFile->storePublicly('public/users');
            $attributes['picture_url'] = $path;

            dd( $path );

        }

        if (!is_null($request->get('password'))) {
            $attributes['password'] = $request->input('password');
        }

        $attributes['is_admin'] = $request->has('is_admin');

        $user->update($attributes);

        return redirect()->route('users.edit', $user)
            ->with('success', 'User successfully updated!');
    }

    /**
     * Remove the specified user from storage.
     *
     * @param  \App\User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')
            ->with('success', 'User successfully deleted!');
    }
}
