<?php

namespace App;

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
    use Notifiable;

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
            'name'        => 'required|filled',
            'email'       => 'required|email|unique',
            'password'    => 'sometimes|filled',
            'picture_url' => ['nullable', 'file', 'image', 'dimensions:ratio=1/1'],
            'is_admin'    => 'required|boolean',
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
}
