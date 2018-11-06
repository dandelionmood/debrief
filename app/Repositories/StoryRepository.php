<?php

namespace App\Repositories;

use App\Story;
use App\Universe;
use App\User;

class StoryRepository
{
    public function findOrCreate(Universe $universe, User $user, $label): Story
    {
        /** @var Story $story */
        $story = Story::firstOrCreate([
            'universe_id' => $universe->id,
            'label'       => $label,
        ], [
            'created_by_user_id'     => $user->id,
            'last_edited_by_user_id' => $user->id,
        ]);

        return $story;
    }

}