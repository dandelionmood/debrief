<?php namespace App\Observers;

use App\Person;
use App\Relation;
use App\Repositories\PersonRepository;
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

        $relations = [];

        $this->handleStoryLinks($story, $relations);
        $this->handlePersonLinks($story, $relations);

//        dd( $relations );

        $story->relations()->saveMany($relations);
    }

    /**
     * We handle story links
     *
     * @param Story $story
     * @param array $relations
     */
    private function handleStoryLinks(Story $story, array &$relations): void
    {
        switch ($story->universe->type) {
            case Universe::TYPE_WIKI:
                preg_match_all('/\[\#([0-9]+)\]/', $story->description, $matches);
                if (!empty($matches[1])) {
                    foreach (array_unique($matches[1]) as $m) {
                        $s = Story::find($m);

                        $relations[] = new Relation([
                            'relatable_to_type' => Story::class,
                            'relatable_to_id'   => $s->id,
                        ]);
                    }
                }
                break;

            case Universe::TYPE_DIARY:
                preg_match_all('/\[([0-9]{4}-[0-9]{2}-[0-9]{2})\]/', $story->description, $matches);
                if (!empty($matches[1])) {
                    foreach (array_unique($matches[1]) as $date) {
                        $s = app()->make(StoryRepository::class)
                            ->findOrCreateForDiary(
                                $story->universe,
                                request()->user(),
                                $date
                            );

                        $relations[] = new Relation([
                            'relatable_to_type' => Story::class,
                            'relatable_to_id'   => $s->id,
                        ]);
                    }
                }
                break;
        }
    }

    /**
     * We handle person links
     *
     * @param Story $story
     * @param array $relations
     */
    private function handlePersonLinks(Story $story, array &$relations): void
    {
        preg_match_all('/\[@([^\]]*)/', $story->description, $matches);
        if (!empty($matches[1])) {
            foreach (array_unique($matches[1]) as $nickname) {
                $p = app()->make(PersonRepository::class)
                    ->findOrCreate(
                        $story->universe,
                        request()->user(),
                        $nickname
                    );

                $relations[] = new Relation([
                    'relatable_to_type' => Person::class,
                    'relatable_to_id'   => $p->id,
                ]);
            }
        }
    }
}