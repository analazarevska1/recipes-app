<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'bio',
        'profile_image',
        'location',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likedPosts()
    {
        return $this->belongsToMany(Post::class, 'like_post')->withTimestamps();
    }

    /**
     * Recipes this user has favorited.
     * (Method renamed from myFaves -> favorites for clarity. myFaves kept as alias.)
     */
    public function favorites()
    {
        return $this->belongsToMany(Post::class, 'favorite_post')->withTimestamps();
    }

    /**
     * Backwards-compatibility alias.
     */
    public function myFaves()
    {
        return $this->favorites();
    }

    /**
     * Profile image URL with fallback.
     */
    public function getProfileImageUrlAttribute(): string
    {
        if (!$this->profile_image) {
            return 'https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png';
        }

        // Handle both relative paths and just the filename
        if (str_starts_with($this->profile_image, 'http')) {
            return $this->profile_image;
        }

        return asset('storage/profile_image/' . $this->profile_image);
    }
}
