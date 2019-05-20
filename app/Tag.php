<?php

namespace App;

use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Support\HtmlString;

class Tag extends Model implements Htmlable
{
    protected $guarded = [];
    public $timestamps = true;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at'];

    public function created_by(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_user_id');
    }

    public function last_edited_by(): BelongsTo
    {
        return $this->belongsTo(User::class, 'last_edited_by_user_id');
    }

    function universe(): BelongsTo
    {
        return $this->belongsTo(Universe::class);
    }

    /**
     *  Stories that are related to this tag in this universe.
     *  @param  Universe $universe 
     *  @return HasManyThrough 
     */
    function related_stories(Universe $universe): HasManyThrough
    {
        return $this->hasManyThrough(Story::class, Relation::class,
            'relatable_to_id', 'id', 'id', 'relatable_id')
            ->where('relatable_to_type', Tag::class)
            ->where('universe_id', '=', $universe->id)
            ->orderBy('updated_at', 'DESC');
    }

    /**
     * @param Universe $universe
     * @return string URL to show the Tag
     */
    public function link(Universe $universe)
    {
        return route('universes.tags.show', [$universe, $this]);
    }

    /**
     *  Render tag to HTML view
     *  @return string 
     */
    public function toHtml(): string
    {
        return sprintf('<span class="badge badge-pill" style="%s"><span class="oi oi-tag"></span>&nbsp;%s</span>',
            sprintf('background-color: %s; color: %s', 
                !empty($this->colour) ? $this->colour : '',
                !empty($this->colour) ? getContrastColor($this->colour) : ''
            ),
            $this->label
        );
    }
}
