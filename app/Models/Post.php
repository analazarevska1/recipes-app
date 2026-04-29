<?php

namespace App\Models;

use App\Models\Tag;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'instructions',
        'ingredients',
        'image',
        'prep_time',
        'cook_time',
        'servings',
        'difficulty',
        'user_id',
    ];

    /**
     * Auto-generate a slug whenever the title changes.
     */
    protected static function booted(): void
    {
        static::saving(function (Post $post) {
            if ($post->isDirty('title') || empty($post->slug)) {
                $post->slug = static::generateUniqueSlug($post->title, $post->id);
            }
        });
    }

    protected static function generateUniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $slug = Str::slug($title);
        $original = $slug;
        $counter = 1;

        while (static::where('slug', $slug)
            ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
            ->exists()) {
            $slug = $original . '-' . $counter++;
        }

        return $slug;
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->latest();
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function likes()
    {
        return $this->belongsToMany(User::class, 'like_post')->withTimestamps();
    }

    public function favorites()
    {
        return $this->belongsToMany(User::class, 'favorite_post')->withTimestamps();
    }

    /**
     * Total time = prep + cook.
     */
    public function getTotalTimeAttribute(): int
    {
        return (int) $this->prep_time + (int) $this->cook_time;
    }

    /**
     * Search scope: matches title, description, or ingredients.
     */
    public function scopeSearch($query, ?string $term)
    {
        if (!$term) {
            return $query;
        }

        return $query->where(function ($q) use ($term) {
            $q->where('title', 'like', "%{$term}%")
              ->orWhere('description', 'like', "%{$term}%")
              ->orWhere('ingredients', 'like', "%{$term}%");
        });
    }

    /**
     * Check if the given user owns this post.
     */
    public function isOwnedBy(?User $user): bool
    {
        return $user && $this->user_id === $user->id;
    }
}
