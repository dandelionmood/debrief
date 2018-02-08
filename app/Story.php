<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Story extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at', 'created_at', 'updated_at'];

    protected $guarded = [];

    function universe()
    {
        return $this->belongsTo(Universe::class);
    }

    function comments()
    {
        return $this->hasMany(Comment::class)
            // comments almost always work in a backward fashion, we acknowledge this by making it our default.
            ->orderByDesc('created_at');
    }
}
