<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Relation extends Model
{
    public $timestamps = false;
    protected $guarded = [];

    public function relatable()
    {
        return $this->morphTo();
    }
}
