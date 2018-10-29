<?php
namespace App\Repositories;

use App\Person;
use App\Universe;
use App\User;

class PersonRepository
{
    public function findOrCreate(Universe $universe, User $user, $nickname): Person
    {
        /** @var Person $person */
        $person = $universe->people()->firstOrNew([
            'nickname' => $nickname,
        ]);

        $person->fill([
            'created_by_user_id'     => $user->id,
            'last_edited_by_user_id' => $user->id,
        ]);

        $person->save();

        $universe->people()->syncWithoutDetaching([$person->id]);

        return $person;
    }

}