<?php

namespace App;

use Baum\Node;

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
    function link()
    {
        return route('universes.stories.show', [$this->universe, $this]);
    }
}
