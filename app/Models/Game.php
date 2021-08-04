<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\Type\Integer;

class Game extends Model
{
    use HasFactory;

    protected $casts = [
        'tags' => 'array',
        'images' => 'array'
    ];

    protected $fillable = [
        'name',
        'user_id',
        'source',
        'width',
        'height',
        'simple_description',
        'detailed_description',
        'fullscreen',
        'public',
        'tags',
        'images',
        'youtube_link',
    ];

    public function user() {
        $user_id = $this->user_id;
        return User::find($user_id);
    }

    public function likedBy(User $user) {
        return $this->likes->contains('user_id', $user->id);
        // return $this->likes()->contains('user_id', $user->id);
    }

    public function likedById($user_id) {
        return $this->likes->contains('user_id', $user_id);
    }

    public function likes() {
        return $this->hasMany(Like::class);
    }

    public function like()  {
        $user = auth()->user();

        if (!auth() || $this->likedBy($user)) {
            return;
        }

        $this->likes()->create([
            'user_id' => $user->id,
        ]);
    }

    public function unlike()  {
        $user = auth()->user();

        if (!auth() || !$this->likedBy($user)) {
            return;
        }

        // maybe likes below should be likes() idk
        $user->likes->where('game_id', $this->id)->delete();
    }

    public function comments() {
        return $this->hasMany(Comment::class);
    }

    public function cover_picture() {
        return $this->picture(0);
    }

    public function picture($index) {
        return $this->images[$index];
    }

}
