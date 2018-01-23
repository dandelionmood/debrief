<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStory;
use App\Story;
use App\Universe;
use Illuminate\Http\Request;

class StoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Universe $universe
     * @return \Illuminate\Http\Response
     */
    public function index(Universe $universe)
    {
        return view('stories.index', ['universe' => $universe, 'stories' => $universe->stories]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Universe $universe
     * @return \Illuminate\Http\Response
     */
    public function create(Universe $universe)
    {
        $story           = with(new Story());
        $story->universe = $universe;
        return view('stories.form', ['story' => $story]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  StoreStory $request
     * @param  \App\Universe $universe
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStory $request, Universe $universe)
    {
        $attributes                = $request->except(['_token']);
        $attributes['universe_id'] = $universe->id;
        $story                     = Story::create($attributes);
        return redirect()->route('universes.stories.show', [$universe->id, $story->id])
            ->with('success', 'Story successfully created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Universe $universe
     * @param  \App\Story $story
     * @return \Illuminate\Http\Response
     */
    public function show(Universe $universe, Story $story)
    {
        return view('stories.show', ['story' => $story]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Universe $universe
     * @param  \App\Story $story
     * @return \Illuminate\Http\Response
     */
    public function edit(Universe $universe, Story $story)
    {
        return view('stories.form', ['story' => $story]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Universe $universe
     * @param  \App\Story $story
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Universe $universe, Story $story)
    {
        $attributes                = $request->except(['_token']);
        $attributes['universe_id'] = $universe->id;
        $story->update($attributes);
        return redirect()->route('universes.stories.show', [$universe->id, $story->id])
            ->with('success', 'Story successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Universe $universe
     * @param  \App\Story $story
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Universe $universe, Story $story)
    {
        $story->delete();
        return redirect()->route('universes.stories.index', $universe->id)
            ->with('success', 'Story successfully archived!');
    }
}
