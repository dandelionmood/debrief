<?php

namespace App;

use Collective\Html\Eloquent\FormAccessible;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Watson\Validating\ValidatingTrait;

class Universe extends Model
{
    const TYPE_WIKI  = 'wiki';
    const TYPE_DIARY = 'diary';

    use FormAccessible;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at'];

    protected $guarded = [];

    use ValidatingTrait;
    protected $rules
                                         = [
            'label'       => 'required',
            'description' => 'nullable',
        ];
    protected $throwValidationExceptions = true;

    public function stories(): HasMany
    {
        return $this->hasMany(Story::class)
            ->whereNotNull('parent_id');
    }

    public function people(): BelongsToMany
    {
        return $this->belongsToMany(Person::class, 'person_universe');
    }

    public function root_story(): HasOne
    {
        return $this->hasOne(Story::class)
            ->whereNull('parent_id');
    }

    /**
     * @return BelongsToMany all the users that have access to this universe
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * @return array all the Universe types available
     */
    public static function getTypes(): array
    {
        return [
            self::TYPE_WIKI  => 'Wiki',
            self::TYPE_DIARY => 'Diary',
        ];
    }

    public static function getForSelect(): array
    {
        $d = [];
        foreach(Universe::all(['id', 'label']) as $u) {
            $d[$u->id] = $u->label;
        }
        return $d;
    }
}
