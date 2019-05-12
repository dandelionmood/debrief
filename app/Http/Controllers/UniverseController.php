<?php

namespace App\Http\Controllers;

use App\Repositories\UniverseRepository;
use App\Universe;
use Illuminate\Http\Request;
use Storage;

class UniverseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('universes.index', ['universes' => request()->user()->universes]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('universes.form', ['universe' => new Universe]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $attributes = $this->getUniverseAttributes($request);

        $universe = Universe::create($attributes);
        $universe->users()->attach($request->user());

        return redirect()->route('universes.index')
            ->with('success', __('Universe successfully created!'));
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
     * @param  Request $request
     * @param  \App\Universe $universe
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Universe $universe)
    {
        $attributes = $this->getUniverseAttributes($request);

        $universe->update($attributes);

        return redirect()->route('universes.show', $universe->id)
            ->with('success', __('Universe successfully updated!'));
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
            ->with('success', __('Universe successfully deleted!'));
    }

    /**
     * @param Request $request
     * @return array
     */
    private function getUniverseAttributes(Request $request): array
    {
        $attributes = $request->except(['_token', '_verb', 'picture']);

        if ($request->hasFile('picture')) {
            $uploadedFile              = $request->file('picture');
            $path                      = $uploadedFile->storePublicly('public/universes');
            $attributes['picture_url'] = Storage::url($path);
        }
        
        return $attributes;
    }
}
