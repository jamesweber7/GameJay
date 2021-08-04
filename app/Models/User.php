<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'username',
        'profile_picture',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function likes() {
        return $this->hasMany(Like::class);
    }

    public function receivedLikes() {
        return $this->hasManyThrough(Like::class, Post::class);
    }

    public const PROFILE_PICTURES = ['blee'];

    public static function randomProfilePicture() {
        return self::PROFILE_PICTURES[array_rand(self::PROFILE_PICTURES, 1)];
    }
    
    public function image() {
        echo "<img src=".asset("storage/profile_pictures/$this->profile_picture.svg")." alt='image'>";
    }

    public function profile_picture() {
        return asset("storage/profile_pictures/$this->profile_picture.svg");
    }
}
