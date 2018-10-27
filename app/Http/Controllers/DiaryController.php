<?php

namespace App\Http\Controllers;

use App\Story;
use App\Universe;
use Illuminate\Http\Request;

class DiaryController extends Controller
{
    public function show(Request $request, $universe_id, $date)
    {
        $universe = Universe::findOrFail($universe_id);

        /** @var Story $story */
        $story = Story::firstOrCreate([
            'universe_id' => $universe->id,
            'label'       => $date,
        ], [
            'created_by_user_id'     => $request->user()->id,
            'last_edited_by_user_id' => $request->user()->id,
        ]);

        // we make sure to update the tree, even though it makes no real
        // sense for diary handling.
        $story->makeChildOf($universe->root_story);

        return redirect($story->link());
    }
}
