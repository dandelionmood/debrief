<?php

namespace Tests\Unit;

use App\Person;
use App\Story;
use App\Universe;
use Illuminate\Support\Collection;
use Tests\TestCase;

/**
 * Tests on the stories specific to links abilities
 * @package Tests\Unit
 */
class StoriesLinksTest extends TestCase
{
    /**
     * We test link across wiki entries
     */
    public function testLinkToAnotherStory()
    {
        $universe = factory(Universe::class)
            ->state('of_type_wiki')->create();

        /** @var Collection $stories */
        $stories = factory(Story::class, 10)
            ->make()
            ->each(function (Story $story) use ($universe) {
                $story->universe()->associate($universe);
                $story->save();
                $story->makeChildOf($universe->root_story->getRoot());
            });

        // We gather all the IDs of stories created
        $stories_ids = $stories->pluck('id')->map(function ($id) {
            return '[#' . $id . ']';
        });

        // We take the first one as our main story, and we'll link ALL stories to this one by simply updating
        // description.
        $main_story = $stories->first();

        $r = $main_story->update(['description' => trim("
            This is a test ! {$stories_ids->implode('  ')} 
            And the following text.
        ")]);

        // Saving main story should work.
        $this->assertTrue($r);

        // Every story must be related to the main story.
        $stories->each(function (Story $s) use ($main_story) {
            $this->assertEquals(1, $s->related_stories()->count());
            $this->assertEquals($main_story->id, $s->related_stories->first()->id);
        });

        // -------------------------------------------

        // Let's try and remove the links.
        $r = $main_story->update(['description' => trim("
            This is a test ! No links anymore 
            And the following text.
        ")]);
        $this->assertTrue($r);
        // The stories shouldn't have any links left
        $stories->each(function (Story $s) {
            $this->assertEquals(0, $s->related_stories()->count());
        });

        // --------------------------------------------

        // Let's try and add a false link !
        $r = $main_story->update(['description' => trim("
            This is a test ! No links anymore [#999999]
            And the following text.
        ")]);
        $this->assertTrue($r);

    }

    /**
     * We test links across diary entries.
     */
    public function testLinkToAnotherDate()
    {
        $universe = factory(Universe::class)
            ->state('of_type_diary')->create();

        $main_story = factory(Story::class)->state('diary_entry')->make();
        $main_story->universe()->associate($universe);
        $main_story->save();
        $main_story->makeChildOf($universe->root_story->getRoot());

        // We only need to generate dates, linked diary entries should be automatically created when saving the
        // main story.
        $dates = collect();
        foreach (range(1, 10) as $i) {
            $dates->push(date('Y-m-d', strtotime("+$i days")));
        }

        $r = $main_story->update(['description' => trim("
            This is a test ! {$dates->map(function($d){ return "[$d]"; })->implode('  ')} 
            And the following text.
        ")]);

        // Saving main story should work.
        $this->assertTrue($r);

        // Every related story must now :
        // - have been automatically created
        // - be related to the main story.
        $stories = $dates->map(function($d) {
           return Story::where('label', '=', $d)->firstOrFail();
        });
        $stories->each(function ($s) use ($main_story) {
            $this->assertEquals(1, $s->related_stories->count());
            $this->assertEquals($main_story->id, $s->related_stories->first()->id);
        });

        // -------------------------------------------

        // Let's try and remove the links.
        $r = $main_story->update(['description' => trim("
            This is a test ! No links anymore 
            And the following text.
        ")]);
        $this->assertTrue($r);
        // The stories shouldn't have any links left
        $stories->each(function (Story $s) {
            $this->assertEquals(0, $s->related_stories()->count());
        });

    }

    /**
     * We should be able to create links to arbitrary people
     * This should work for both types of universes.
     */
    public function testlinkToPeople()
    {
        $universe = factory(Universe::class)
            ->state('of_type_diary')->create();

        /** @var Story $main_story */
        $main_story = factory(Story::class)->state('diary_entry')->make();
        $main_story->universe()->associate($universe);
        $main_story->save();
        $main_story->makeChildOf($universe->root_story->getRoot());

        $r = $main_story->update(['description' => trim("
            This is a test ! [@pierre]
        ")]);
        $this->assertTrue($r);

        // One person should now be registered as being mentioned in the story
        $this->assertEquals(1, $main_story->mentioned_people()->count());
        $this->assertEquals('pierre', $main_story->mentioned_people->first()->nickname);

        // On the other end, we should be able to list the stories for this person.
        /** @var Person $person */
        $person = $main_story->mentioned_people->first();
        $this->assertEquals(1, $person->related_stories($universe)->count());
        $this->assertEquals($main_story->id, $person->related_stories($universe)->first()->id);

        // -------------------------------------------

        // We now try and remove this relation
        $r = $main_story->update(['description' => trim("
            This is a test ! No links anymore 
            And the following text.
        ")]);
        $this->assertTrue($r);
        $this->assertEquals(0, $main_story->mentioned_people()->count());
    }
}
