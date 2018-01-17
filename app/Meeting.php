<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    public function universe()
    {
        return $this->belongsTo(Universe::class);
    }

    public function stories()
    {
        return $this->hasMany(Story::class);
    }
}
