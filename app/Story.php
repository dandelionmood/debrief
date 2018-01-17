<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Story extends Model
{
    function user()
    {
        return $this->belongsTo(User::class);
    }
}
