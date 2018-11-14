<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Watson\Validating\ValidatingTrait;

/**
 * App\User
 *
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @mixin \Eloquent
 */
class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable
        = [
            'name',
            'email',
            'password',
            'is_admin',
            'picture_url',
        ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden
        = [
            'password',
            'remember_token',
        ];

    use ValidatingTrait;
    protected $rules
                                         = [
            'name'     => 'required|filled',
            'email'    => 'required|email|unique',
            'password' => 'sometimes|filled',
            'is_admin' => 'required|boolean',
        ];
    protected $throwValidationExceptions = true;

    public function universes()
    {
        return $this->belongsToMany(Universe::class);
    }

    public function stories()
    {
        return $this->hasManyThrough(Story::class, Universe::class);
    }

    public function getPictureUrlAttribute($pictureUrl)
    {
        return empty($pictureUrl)
            ? 'https://ssl.gstatic.com/accounts/ui/avatar_2x.png'
            : $pictureUrl;
    }
}
