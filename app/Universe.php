<?php

namespace App;

use Collective\Html\Eloquent\FormAccessible;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Universe extends Model
{
    use FormAccessible;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at', 'created_at', 'updated_at'];

    protected $guarded = [];

    public function meetings()
    {
        return $this->hasMany(Meeting::class);
    }

    public function stories()
    {
        return $this->hasMany(Story::class)
            ->whereNotNull('parent_id');
    }

    public function root_story()
    {
        return $this->hasOne(Story::class)
            ->whereNull('parent_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
