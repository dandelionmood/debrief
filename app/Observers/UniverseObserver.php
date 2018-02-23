<?php namespace App\Observers;

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
        $story_tree = new Story([
            'label' => 'Root story',
        ]);
        $universe->stories()->save($story_tree);
        $story_tree->makeRoot();
    }
}