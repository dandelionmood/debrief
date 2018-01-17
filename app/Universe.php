<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Universe extends Model
{
    public function meetings()
    {
        return $this->hasMany(Meeting::class);
    }
}
