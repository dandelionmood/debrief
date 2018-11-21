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
        if ($universe->type === Universe::TYPE_DIARY) {
            return redirect()->route('universes.stories.diary.date', [
                $universe, strftime('%F'),
            ]);
        }

        return view('stories.index', [
            'universe' => $universe,
            'stories'  => $universe->stories,
        ]);
    }

    /**
     * Store a newly created story in storage.
     *
     * @param Request $request
     * @param $universe_id
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request, Universe $universe)
    {
        $attributes                           = [];
        $attributes['universe_id']            = $universe->id;
        $attributes['created_by_user_id']     = $request->user()->id;
        $attributes['last_edited_by_user_id'] = $request->user()->id;
        $attributes['label']                  = "New story";
        $story                                = Story::create($attributes);

        $parent_story_id = $request->get('parent_story_id');
        if (!empty($parent_story_id)) {
            $story->makeChildOf(Story::find($parent_story_id));
        }

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
