<?php namespace App\Observers;

use App\Relation;
use App\Repositories\StoryRepository;
use App\Story;
use App\Universe;

class StoryObserver
{
    /**
     * @param  Story $story
     * @return void
     */
    public function saved(Story $story)
    {
        $story->relations()->delete();

        switch ($story->universe->type) {
            case Universe::TYPE_WIKI:
                preg_match_all('/\[\#([0-9]+)\]/', $story->description, $matches);
                if (!empty($matches[1])) {
                    $relations = [];
                    foreach (array_unique($matches[1]) as $m) {
                        $s           = Story::find($m);
                        $relations[] = Relation::firstOrNew([
                            'relatable_to_type' => Story::class,
                            'relatable_to_id'   => $s->id,
                        ]);
                    }
                    $story->relations()->saveMany($relations);
                }
                break;

            case Universe::TYPE_DIARY:
                preg_match_all('/\[([0-9]{4}-[0-9]{2}-[0-9]{2})\]/', $story->description, $matches);
                if (!empty($matches[1])) {
                    $relations = [];
                    foreach (array_unique($matches[1]) as $date) {
                        $s = app()->make(StoryRepository::class)
                            ->findOrCreateForDiary(
                                $story->universe,
                                request()->user(),
                                $date
                            );
                        $relations[] = Relation::firstOrNew([
                            'relatable_to_type' => Story::class,
                            'relatable_to_id'   => $s->id,
                        ]);
                    }
                    $story->relations()->saveMany($relations);
                }
                break;
        }
    }
}