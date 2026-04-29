<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    /**
     * Show a user's public profile and their recipes.
     */
    public function show(User $user)
    {
        $posts = $user->posts()
            ->with('tags')
            ->withCount(['likes', 'favorites', 'comments'])
            ->latest()
            ->paginate(9);

        $stats = [
            'recipes'  => $user->posts()->count(),
            'likes'    => $user->posts()->withCount('likes')->get()->sum('likes_count'),
            'favorites'=> $user->posts()->withCount('favorites')->get()->sum('favorites_count'),
        ];

        return view('users.show', compact('user', 'posts', 'stats'));
    }
}
