<?php

namespace App\Http\Controllers;

use App\Tag;
use App\Universe;
use Illuminate\Http\Request;

class TagsController extends Controller
{
    public function show(Request $request, Universe $universe, Tag $tag)
    {
        return view('tags.show', [
            'universe' => $universe,
            'tag'      => $tag,
        ]);
    }

    /**
     * Update the tag in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  Universe $universe
     * @param  Tag $tag
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Universe $universe, Tag $tag)
    {
        $attributes                           = $request->except(['_token']);
        $attributes['last_edited_by_user_id'] = $request->user()->id;
        $tag->update($attributes);
        
        return redirect($tag->link($universe))
            ->with('success', __('Tag successfully updated!'));
    }
}
