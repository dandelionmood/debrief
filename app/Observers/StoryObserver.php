<?php namespace App\Observers;

use App\Person;
use App\Relation;
use App\Repositories\PersonRepository;
use App\Repositories\StoryRepository;
use App\Repositories\TagRepository;
use App\Story;
use App\Tag;
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
        $this->handleTagLinks($story, $relations);

//        dd( $relations );

        $story->relations()->saveMany($relations);
    }

    public function deleting(Story $story)
    {
        // We make sure to delete children stories as well.
        $story->children()->delete();
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
                        if ($s !== null) { // if the link is wrong, we simply carry on.
                            $relations[] = new Relation([
                                'relatable_to_type' => Story::class,
                                'relatable_to_id'   => $s->id,
                            ]);
                        }
                    }
                }
                break;

            case Universe::TYPE_DIARY:
                preg_match_all('/\[([0-9]{4}-[0-9]{2}-[0-9]{2})\]/', $story->description, $matches);
                if (!empty($matches[1])) {
                    foreach (array_unique($matches[1]) as $date) {
                        $s = app()->make(StoryRepository::class)
                            ->findOrCreate(
                                $story->universe,
                                $story->last_edited_by, // the related story was just saved by this user : we assume it's the same.
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
                        $story->last_edited_by, // the related story was just saved by this user : we assume it's the same.
                        $nickname
                    );

                $relations[] = new Relation([
                    'relatable_to_type' => Person::class,
                    'relatable_to_id'   => $p->id,
                ]);
            }
        }
    }

    /**
     * We handle tags links
     *
     * @param Story $story
     * @param array $relations
     */
    private function handleTagLinks(Story $story, array &$relations): void
    {
        preg_match_all('/\[!([^\]]*)/', $story->description, $matches);
        if (!empty($matches[1])) {
            foreach (array_unique($matches[1]) as $nickname) {
                $p = app()->make(TagRepository::class)
                    ->findOrCreate(
                        $story->universe,
                        $story->last_edited_by, // the related story was just saved by this user : we assume it's the same.
                        $nickname
                    );

                $relations[] = new Relation([
                    'relatable_to_type' => Tag::class,
                    'relatable_to_id'   => $p->id,
                ]);
            }
        }
    }
}