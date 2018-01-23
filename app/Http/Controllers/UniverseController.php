<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUniverse;
use App\Universe;
use Illuminate\Http\Request;

class UniverseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('universes.index', ['universes' => Universe::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('universes.form', ['universe' => new Universe()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreUniverse $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUniverse $request)
    {
        $attributes            = $request->except(['_token']);
        $attributes['user_id'] = $request->user()->id;
        Universe::create($attributes);
        return redirect()->route('universes.index')
            ->with('success', 'Universe successfully created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Universe $universe
     * @return \Illuminate\Http\Response
     */
    public function show(Universe $universe)
    {
        return view('universes.show', ['universe' => $universe]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Universe $universe
     * @return \Illuminate\Http\Response
     */
    public function edit(Universe $universe)
    {
        return view('universes.form', ['universe' => $universe]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  StoreUniverse $request
     * @param  \App\Universe $universe
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUniverse $request, Universe $universe)
    {
        $attributes            = $request->except(['_token']);
        $attributes['user_id'] = $request->user()->id;
        $universe->update($attributes);
        return redirect()->route('universes.show', $universe->id)
            ->with('success', 'Universe successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Universe $universe
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Universe $universe)
    {
        $universe->delete();
        return redirect()->route('universes.index')
            ->with('success', 'Universe successfully archived!');
    }
}
