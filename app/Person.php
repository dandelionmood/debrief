<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Person extends Model
{
    protected $table = 'people';

    protected $guarded    = [];
    public    $timestamps = true;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at'];

    function created_by(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_user_id');
    }

    function last_edited_by(): BelongsTo
    {
        return $this->belongsTo(User::class, 'last_edited_by_user_id');
    }

    function relations(): MorphMany
    {
        return $this->morphMany(Relation::class, 'relatable');
    }

    function universes(): BelongsToMany
    {
        return $this->belongsToMany(Universe::class, 'person_universe');
    }

    function related_stories(Universe $universe)
    {
        return $this->hasManyThrough(Story::class, Relation::class,
            'relatable_to_id', 'id', 'id', 'relatable_id')
            ->where('relatable_to_type', Person::class)
            ->where('universe_id', '=', $universe->id)
            ->orderBy('updated_at', 'DESC');
    }


    public function getLabelAttribute()
    {
        if( !empty($this->first_name) || !empty($this->last_name) ) {
            return "$this->first_name $this->last_name";
        }
        else {
            return "@$this->nickname";
        }
    }

    /**
     * @param Universe $universe
     * @return string URL to show the Person
     */
    public function link(Universe $universe)
    {
        return route('universes.people.show', [$universe, $this]);
    }

}
