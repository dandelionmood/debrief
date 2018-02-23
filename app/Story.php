<?php

namespace App;

use Baum\Node;
use Illuminate\Database\Eloquent\SoftDeletes;

class Story extends Node
{
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at', 'created_at', 'updated_at'];

    /**
     * Stories are scoped through their universe.
     * @var array
     */
    protected $scoped = ['universe_id'];

    function universe()
    {
        return $this->belongsTo(Universe::class);
    }

    function created_by()
    {
        return $this->belongsTo(User::class, 'created_by_user_id');
    }

    function last_edited_by()
    {
        return $this->belongsTo(User::class, 'last_edited_by_user_id');
    }

    function comments()
    {
        return $this->hasMany(Comment::class)
            // comments almost always work in a backward fashion, we acknowledge this by making it our default.
            ->orderByDesc('created_at');
    }
}
