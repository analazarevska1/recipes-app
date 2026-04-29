<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * List all recipes with search + tag filter + pagination.
     */
    public function index(Request $request)
    {
        $query = Post::with('author', 'tags')
            ->withCount(['likes', 'favorites', 'comments'])
            ->latest();

        // Search
        if ($request->filled('q')) {
            $query->search($request->q);
        }

        // Filter by tag
        if ($request->filled('tag')) {
            $query->whereHas('tags', fn($q) => $q->where('name', $request->tag));
        }

        $posts = $query->paginate(9)->withQueryString();
        $tags = Tag::orderBy('name')->get();

        return view('posts.all-posts', compact('posts', 'tags'));
    }

    public function create()
    {
        $tags = Tag::orderBy('name')->get();
        return view('posts.create', compact('tags'));
    }

    public function store(Request $request)
    {
        $data = $this->validatePost($request);

        $path = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('images', 'public');
        }

        $post = Post::create([
            'title'        => $data['title'],
            'description'  => $data['description'] ?? null,
            'instructions' => $data['instructions'] ?? null,
            'ingredients'  => $data['ingredients'] ?? null,
            'image'        => $path,
            'cook_time'    => $data['cook_time'] ?? null,
            'prep_time'    => $data['prep_time'] ?? null,
            'servings'     => $data['servings'] ?? null,
            'difficulty'   => $data['difficulty'] ?? null,
            'user_id'      => auth()->id(),
        ]);

        if ($request->filled('tags')) {
            $post->tags()->sync($request->tags);
        }

        return redirect()
            ->route('posts.show', $post)
            ->with('success', 'Recipe added!');
    }

    public function show(Post $post)
    {
        $post->load(['author', 'tags', 'comments.user', 'likes', 'favorites']);
        return view('posts.one-post', compact('post'));
    }

    /**
     * Show the edit form. Only the author can edit.
     */
    public function edit(Post $post)
    {
        $this->authorizePost($post);
        $tags = Tag::orderBy('name')->get();
        return view('posts.edit', compact('post', 'tags'));
    }

    /**
     * Update the recipe. Only the author can update.
     */
    public function update(Request $request, Post $post)
    {
        $this->authorizePost($post);

        $data = $this->validatePost($request);

        if ($request->hasFile('image')) {
            // Delete the old image (only if it was a local upload)
            if ($post->image && !str_starts_with($post->image, 'http')) {
                Storage::disk('public')->delete($post->image);
            }
            $post->image = $request->file('image')->store('images', 'public');
        }

        $post->fill([
            'title'        => $data['title'],
            'description'  => $data['description'] ?? null,
            'instructions' => $data['instructions'] ?? null,
            'ingredients'  => $data['ingredients'] ?? null,
            'cook_time'    => $data['cook_time'] ?? null,
            'prep_time'    => $data['prep_time'] ?? null,
            'servings'     => $data['servings'] ?? null,
            'difficulty'   => $data['difficulty'] ?? null,
        ])->save();

        $post->tags()->sync($request->tags ?? []);

        return redirect()
            ->route('posts.show', $post)
            ->with('success', 'Recipe updated!');
    }

    /**
     * Delete the recipe. Only the author can delete.
     */
    public function destroy(Post $post)
    {
        $this->authorizePost($post);

        if ($post->image && !str_starts_with($post->image, 'http')) {
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();

        return redirect()
            ->route('posts.index')
            ->with('success', 'Recipe deleted.');
    }

    public function like(Post $post)
    {
        $user = auth()->user();
        $post->likes()->toggle($user->id);
        return back();
    }

    public function favorite(Post $post)
    {
        $user = auth()->user();
        $post->favorites()->toggle($user->id);
        return back();
    }

    public function favPosts()
    {
        $favorites = auth()->user()
            ->favorites()
            ->with('author', 'tags')
            ->withCount(['likes', 'comments'])
            ->latest('favorite_post.created_at')
            ->get();

        return view('posts.favorites', compact('favorites'));
    }

    /**
     * Filter posts by tag (kept for backwards compatibility with /posts/tag/{tag}).
     */
    public function tags(Request $request)
    {
        return redirect()->route('posts.index', ['tag' => $request->tag]);
    }

    /**
     * Print-friendly view of a recipe (no nav, no footer, just the recipe).
     */
    public function print(Post $post)
    {
        $post->load(['author', 'tags']);
        return view('posts.print', compact('post'));
    }

    // ---------- helpers ----------

    private function validatePost(Request $request): array
    {
        return $request->validate([
            'title'        => 'required|string|max:255',
            'description'  => 'nullable|string|max:1000',
            'instructions' => 'required|string',
            'ingredients'  => 'required|string',
            'cook_time'    => 'nullable|integer|min:0|max:1440',
            'prep_time'    => 'nullable|integer|min:0|max:1440',
            'servings'     => 'nullable|integer|min:1|max:100',
            'difficulty'   => 'nullable|in:Easy,Medium,Hard',
            'image'        => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:4096',
            'tags'         => 'nullable|array',
            'tags.*'       => 'integer|exists:tags,id',
        ]);
    }

    private function authorizePost(Post $post): void
    {
        abort_unless($post->isOwnedBy(auth()->user()), 403, 'You do not own this recipe.');
    }
}
