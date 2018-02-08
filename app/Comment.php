<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    protected $dates = ['deleted_at', 'created_at', 'updated_at'];

    protected $guarded = [];

    use SoftDeletes;

    public function story()
    {
        return $this->belongsTo(Story::class);
    }

    public function meeting()
    {
        return $this->belongsTo(Meeting::class);
    }
}
