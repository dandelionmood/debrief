<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    protected $dates = ['deleted_at', 'created_at', 'updated_at'];

    protected $guarded = [];

    public function story()
    {
        return $this->belongsTo(Story::class);
    }

    public function meeting()
    {
        return $this->belongsTo(Meeting::class);
    }

    function created_by()
    {
        return $this->belongsTo(User::class, 'created_by_user_id');
    }

    function last_edited_by()
    {
        return $this->belongsTo(User::class, 'last_edited_by_user_id');
    }
}
