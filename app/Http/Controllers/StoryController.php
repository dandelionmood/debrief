<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStory;
use App\Story;
use App\Universe;
use Illuminate\Http\Request;

class StoryController extends Controller
{
    /**
     * Display a listing of the stories.
     *
     * @param  \App\Universe $universe
     * @return \Illuminate\Http\Response
     */
    public function index(Universe $universe)
    {
        // That doesn't make much sense for a diary : we go simply
        // to the current date.
        if( $universe->type === Universe::TYPE_DIARY ) {
            return redirect()->route('universes.stories.diary.date', [
                $universe, strftime('%F')
            ]);
        }

        return view('stories.index', [
            'universe' => $universe,
            'stories' => $universe->stories
        ]);
    }

    /**
     * Show the form for creating a new story.
     *
     * @param  \App\Universe $universe
     * @return \Illuminate\Http\Response
     */
    public function create(Universe $universe)
    {
        $story              = with(new Story());
        $story->universe_id = $universe->id;
        return view('stories.form', ['story' => $story]);
    }

    /**
     * Store a newly created story in storage.
     *
     * @param  StoreStory $request
     * @param  \App\Universe $universe
     * @return \Illuminate\Http\Response
     */
    public function store(StoreStory $request, Universe $universe)
    {
        $attributes                           = $request->except(['_token']);
        $attributes['universe_id']            = $universe->id;
        $attributes['created_by_user_id']     = $request->user()->id;
        $attributes['last_edited_by_user_id'] = $request->user()->id;
        $attributes['slug']                   = str_limit(str_slug($attributes['label'], 255));
        $story                                = Story::create($attributes);

        return redirect($story->link())
            ->with('success', 'Story successfully created!');
    }

    /**
     * Update the story in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Universe $universe
     * @param  \App\Story $story
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Universe $universe, Story $story)
    {
        $attributes                           = $request->except(['_token']);
        $attributes['universe_id']            = $universe->id;
        $attributes['last_edited_by_user_id'] = $request->user()->id;
        $story->update($attributes);

        return redirect($story->link())
            ->with('success', 'Story successfully updated!');
    }

    /**
     * Display the story.
     *
     * @param  \App\Universe $universe
     * @param  \App\Story $story
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Universe $universe, Story $story)
    {
        // We need to give some context to Parsedown to make it work.
        // @todo maybe move this code elsewhere (middleware ?)
        app('parsedown')->setUniverse($universe);
        app('parsedown')->setUser($request->user());

        return view('stories.show', ['story' => $story]);
    }

    /**
     * Show the form for editing the story.
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
     * Remove the story from storage.
     *
     * @param  \App\Universe $universe
     * @param  \App\Story $story
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Universe $universe, Story $story)
    {
        $story->delete();
        return redirect()->route('universes.show', ['universe' => $universe])
            ->with('success', 'Story successfully deleted!');
    }
}
