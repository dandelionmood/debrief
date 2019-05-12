<?php

namespace App\Http\Controllers;

use App\Repositories\StoryRepository;
use App\Universe;
use Illuminate\Http\Request;

class StoryDiaryController extends Controller
{
    public function show_or_create(Request $request, Universe $universe, $date)
    {
        $story = app()->make(StoryRepository::class)
            ->findOrCreate(
                $universe,
                $request->user(),
                $date
            );

        $r = redirect($story->link());

        // This message as no meaning if the entry already existed.
        if( $story->wasRecentlyCreated )
            $r = $r->with('success', __("Successfully added a new diary entry."));

        return $r;
    }
}
