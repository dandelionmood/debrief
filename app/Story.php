<?php

namespace App;

use Baum\Extensions\Query\Builder;
use Baum\Node;
use Illuminate\Support\Collection;

class Story extends Node
{
    protected $guarded = [];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at'];

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

    function relations()
    {
        return $this->morphMany(Relation::class, 'relatable');
    }

    function related_stories()
    {
        // This a clever trick to use our polymorphic relationship WITH
        // an as many through to avoid dealing with meaningless Relation
        // objects.
        return $this->hasManyThrough(Story::class, Relation::class,
            'relatable_to_id', 'id', 'id', 'relatable_id')
            ->where('relatable_to_type', Story::class);
    }

    /**
     * Automatic label conversion : it depends on the universe type.
     *
     * @param $label string original label
     * @return string
     */
    public function getLabelAttribute($label): string
    {
        switch ($this->universe->type) {
            case Universe::TYPE_DIARY:
                $label = \Carbon\Carbon::parse($label)->formatLocalized('%A %d %B %Y');
                break;
        }

        return $label;
    }

    /**
     * Common method to get a link for the story.
     *
     * @return string a http link to show the story
     */
    public function link()
    {
        return route('universes.stories.show', [$this->universe, $this]);
    }
}
