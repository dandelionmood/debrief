<?php

namespace App\Http\Controllers;

use App\Repositories\StoryRepository;
use App\Universe;
use Illuminate\Http\Request;

class StoryDiaryController extends Controller
{
    public function show_or_create(Request $request, $universe_id, $date)
    {
        /** @var Universe $universe */
        $universe = Universe::findOrFail($universe_id);

        $story = app()->make(StoryRepository::class)
            ->findOrCreate(
                $universe,
                $request->user(),
                $date
            );

        return redirect($story->link())
            ->with('success', "Successfully added a new diary entry.");
    }
}
