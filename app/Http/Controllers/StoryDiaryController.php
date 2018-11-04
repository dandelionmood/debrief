<?php

namespace App\Http\Controllers;

use App\Repositories\StoryRepository;
use App\Universe;
use Illuminate\Http\Request;

class StoryDiaryController extends Controller
{
    public function show(Request $request, $universe_id, $date)
    {
        /** @var Universe $universe */
        $universe = Universe::findOrFail($universe_id);

        $story = app()->make(StoryRepository::class)
            ->findOrCreateForDiary(
                $universe,
                $request->user(),
                $date
            );

        // we make sure to update the tree, even though it makes no real
        // sense for diary handling.
        $story->makeChildOf($universe->root_story);

        return redirect($story->link())
            ->with('success', "Successfully added a new diary entry.");
    }
}
