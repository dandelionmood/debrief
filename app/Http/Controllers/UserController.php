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
        return view('users.index', [
            'users' =>
                User::query()
                    ->withTrashed()
                    ->orderBy('name')
                    ->get(),
        ]);
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
        $attributes = $this->getUserAttributes($request);
        $user = User::create($attributes);
        $user->universes()->sync($request->get('universes'));
        return redirect()->route('users.index')
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
        $attributes = $this->getUserAttributes($request);
        $user->update($attributes);
        $user->universes()->sync($request->get('universes'));
        return redirect()->route('users.index')
            ->with('success', 'User successfully updated!');
    }

    /**
     * Remove the specified user from storage.
     *
     * @param  \App\User $user
     * @throws
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        \Auth::logoutOtherDevices($user->getAuthPassword());
        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'User disabled!');
    }

    public function restore(User $user)
    {
        $user->restore();

        return redirect()->route('users.index')
            ->with('success', 'User was successfully enabled!');
    }

    /**
     * @param Request $request
     * @return array
     */
    private function getUserAttributes(Request $request): array
    {
        $attributes = $request->except(['_token', '_method', 'picture', 'password', 'universes']);

        if ($request->hasFile('picture')) {
            $uploadedFile              = $request->file('picture');
            $path                      = $uploadedFile->storePublicly('public/users');
            $attributes['picture_url'] = Storage::url($path);
        }

        if (!is_null($request->get('password'))) {
            $attributes['password'] = \Hash::make($request->input('password'));
        }

        $attributes['is_admin'] = $request->has('is_admin');

        return $attributes;
    }
}
