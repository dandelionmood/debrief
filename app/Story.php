<?php

namespace App;

use Baum\Node;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Watson\Validating\ValidatingTrait;

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

    use ValidatingTrait;
    protected $rules
                                         = [
            'label'                  => 'required|filled',
            'description'            => 'nullable',
            'universe_id'            => 'required|numeric|exists:universes,id',
            'last_edited_by_user_id' => 'numeric|exists:users,id',
            'created_by_user_id'     => 'numeric|exists:users,id',
        ];

    protected $throwValidationExceptions = true;

    function universe(): BelongsTo
    {
        return $this->belongsTo(Universe::class);
    }

    function created_by(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by_user_id');
    }

    function last_edited_by(): BelongsTo
    {
        return $this->belongsTo(User::class, 'last_edited_by_user_id');
    }

    function comments(): HasMany
    {
        return $this->hasMany(Comment::class)
            // comments almost always work in a backward fashion, we acknowledge this by making it our default.
            ->orderByDesc('created_at');
    }

    /**
     * @return MorphMany All the «relations» via the relatable relationship.
     */
    function relations(): MorphMany
    {
        return $this->morphMany(Relation::class, 'relatable');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     *  Stories that are related to this one.
     */
    function related_stories(): HasManyThrough
    {
        // This a clever trick to use our polymorphic relationship WITH
        // an as many through to avoid dealing with meaningless Relation
        // objects.
        return $this->hasManyThrough(Story::class, Relation::class,
            'relatable_to_id', 'id', 'id', 'relatable_id')
            ->where('relatable_to_type', Story::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     *  People that got mentioned in this story.
     */
    function mentioned_people(): HasManyThrough
    {
        return $this->hasManyThrough(Person::class, Relation::class,
            'relatable_id', 'id', 'id', 'relatable_to_id')
            ->where('relatable_to_type', Person::class);
    }

    /**
     * Automatic label conversion : it depends on the universe type.
     *
     * @param $label string original label
     * @return string
     */
    public function getLabelAttribute($label): ?string
    {
        switch ($this->universe->type) {
            case Universe::TYPE_DIARY:
                if (!$this->isRoot()) {
                    $label = ucfirst(\Carbon\Carbon::parse($label)->formatLocalized('%A %d %B %Y'));
                }
                break;
        }

        return $label;
    }

    /**
     * Common method to get a link for the story.
     *
     * @return string a http link to show the story
     */
    public function link(): string
    {
        return route('universes.stories.show', [$this->universe, $this]);
    }
}
