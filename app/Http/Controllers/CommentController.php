<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Story;
use App\Universe;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Store a newly created comment in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param \App\Universe $universe
     * @param  \App\Story $story
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Universe $universe, Story $story)
    {
        $attributes                           = $request->except(['_token']);
        $attributes['story_id']               = $story->id;
        $attributes['created_by_user_id']     = $request->user()->id;
        $attributes['last_edited_by_user_id'] = $request->user()->id;

        Comment::create($attributes);

        return redirect($story->link())
            ->with('success', 'Comment successfully added!');
    }

    /**
     * Update the comment in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param \App\Universe $universe
     * @param  \App\Story $story
     * @param  \App\Comment $comment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Universe $universe, Story $story, Comment $comment)
    {
        $attributes                           = $request->except(['_token']);
        $attributes['story_id']               = $story->id;
        $attributes['last_edited_by_user_id'] = $request->user()->id;
        $comment->update($attributes);

        return redirect($story->link())
            ->with('success', 'Comment successfully updated!');
    }

    /**
     * Remove the comment from storage.
     *
     * @param \App\Universe $universe
     * @param  \App\Story $story
     * @param  \App\Comment $comment
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Universe $universe, Story $story, Comment $comment)
    {
        $comment->delete();

        return redirect($story->link())
            ->with('success', 'Comment successfully archived!');
    }
}
