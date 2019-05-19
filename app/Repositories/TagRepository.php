<?php

namespace App\Repositories;

use App\Tag;
use App\Universe;
use App\User;

class TagRepository
{
    public function findOrCreate(Universe $universe, User $user, $label): Tag
    {
        /** @var Tag $tag */
        $tag = Tag::firstOrCreate([
            'universe_id' => $universe->id,
            'label'       => $label,
        ], [
            'created_by_user_id'     => $user->id,
            'last_edited_by_user_id' => $user->id,
        ]);

        return $tag;
    }
}