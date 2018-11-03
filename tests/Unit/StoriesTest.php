<?php

namespace Tests\Unit;

use App\Story;
use App\Universe;
use Tests\TestCase;

class StoriesTest extends TestCase
{
    public function testBasicDiaryStory()
    {
        $universe = factory(Universe::class)
            ->state('of_type_diary')->create();

        factory(Story::class, 10)->state('diary_entry')
            ->make()
            ->each(function (Story $story) use ($universe) {
                $story->universe()->associate($universe);
                $story->save();
                $story->makeChildOf($universe->root_story->getRoot());
            });

        $this->assertEquals(10, count($universe->stories));
    }

    public function testBasicWikiStory()
    {
        $universe = factory(Universe::class)
            ->state('of_type_wiki')->create();

        factory(Story::class, 10)
            ->make()
            ->each(function (Story $story) use ($universe) {
                $story->universe()->associate($universe);
                $story->save();
                $story->makeChildOf($universe->root_story->getRoot());
            });

        $this->assertEquals(10, count($universe->stories));
    }

    /*
    public function testLinkToAnotherStory()
    {

    }

    public function testLinkToAnotherDate()
    {

    }
    */
}
