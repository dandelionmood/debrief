<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public function story()
    {
        return $this->belongsTo(Story::class);
    }

    public function meeting()
    {
        return $this->belongsTo(Meeting::class);
    }
}
