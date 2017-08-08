<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    public $appends = ['path'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getPathAttribute()
    {
        return url('/api/v1/users/'.$this->id);
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function avatar()
    {
        return $this->hasOne(Avatar::class);
    }

    protected static function boot()
    {
        parent::boot();
        self::saved(function ($user) {
            $user->avatar()
                ->create([
                    'path' => 'https://www.gravatar.com/avatar/'.md5($user->email),
                ]);
        });
    }
}
