<?php namespace App\Observers;

use App\Repositories\StoryRepository;
use App\Story;
use App\Universe;

class UniverseObserver
{
    /**
     * Listen to the User created event.
     *
     * @param  Universe $universe
     * @return void
     */
    public function created(Universe $universe)
    {
        // We need to initialize the Baum tree lib by giving it
        // a root node.
        $story_tree = new Story([
            'label' => 'Root story',
        ]);
        $universe->stories()->save($story_tree);
        $story_tree->makeRoot();
    }
}