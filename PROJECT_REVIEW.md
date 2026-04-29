# Project Review — TastyShare

A friendly, honest review of the project after the rewrite. The good, the meh, and what to learn next.

---

## ✅ What's already good

You'd be surprised — most second-year students don't have a project this complete.

- **Real domain model.** Posts, Tags, Users, Comments, Likes, Favourites, with proper many-to-many pivot tables (`post_tag`, `like_post`, `favorite_post`). That's the kind of relational thinking employers look for.
- **Migrations are clean** — each one does one thing.
- **Auth is in place** (Laravel Breeze) — and you customised the User model to add bio/profile_image/location, which shows you understood what was happening rather than treating Breeze as a black box.
- **You used Eloquent relationships** instead of raw SQL. `belongsToMany`, `hasMany`, `belongsTo` — all in the right places.
- **Form validation** lives in the controller (now improved), and you handle file uploads correctly with `store('images', 'public')`.
- **The data structure makes sense** — separating ingredients/instructions from description, having prep_time/cook_time/servings, those are good product decisions.

This is a solid foundation. Don't underrate it.

---

## ⚠️ Things that were issues (now fixed)

These are real problems that I corrected in the rewrite — but you should understand *why* they were issues:

### 1. Empty CRUD methods
Your `edit()`, `update()`, and `destroy()` methods on `PostController` were empty. Users could create recipes but never edit or delete them. **For any resource your users own, the full CRUD cycle is table stakes.**

### 2. No authorization
Even when those methods were filled in, anyone logged in could edit anyone else's posts unless you check ownership. The fix:
```php
abort_unless($post->isOwnedBy(auth()->user()), 403);
```
This is the simple version. The Laravel-idiomatic version uses **Policies** (`php artisan make:policy PostPolicy --model=Post`). Worth learning next.

### 3. N+1 queries
On the recipes index, `Post::with('author','tags')->get()` was good, but you weren't using `withCount()` for likes/comments/favourites. So every recipe card triggered 3 extra queries. With 100 recipes, that's 300 queries. The fix:
```php
Post::with('author', 'tags')->withCount(['likes', 'favorites', 'comments'])
```

### 4. Loading every post at once
`->get()` returns *all* records. With 1,000 recipes, your page would die. **`->paginate(9)` is what you want** — Laravel handles the rest, including the page navigation links.

### 5. No search
Hard to call something a recipe app without search. I added a query scope on the Post model:
```php
public function scopeSearch($query, ?string $term) { ... }
```
This is a clean pattern — the search logic lives on the model, not in the controller, so you can reuse it.

### 6. Tailwind via CDN AND Vite
`main.blade.php` had `<script src="https://cdn.tailwindcss.com">` while `vite.config.js` was already set up with Tailwind. Two systems doing the same job. The CDN version doesn't include your config (custom colors, fonts), so any custom theme was getting ignored. **Pick Vite for production** — it tree-shakes unused classes and your CSS bundle ends up tiny.

### 7. Default Laravel README
Your README was the framework's marketing page, not your project's description. A README is the first thing recruiters and collaborators read. It should answer: *what is this, what does it do, how do I run it.*

### 8. UI was unfinished
The all-posts page rendered colored bars, no images. The home page had the same paragraph copy-pasted twice. Typography mixed serif/mono/sans randomly. Nothing was *bad* — it just looked like work-in-progress, not finished work.

---

## 🔒 Things still worth thinking about (security & robustness)

I didn't fix all of these — they're worth knowing about as you grow.

### Image uploads aren't bullet-proof
You validate `mimes:jpg,jpeg,png,gif,webp`, which is good. But MIME types can be spoofed. For real production:
- Validate file size (`max:4096`) ✓ (added)
- Consider re-encoding images server-side (using **Intervention Image**) to strip any embedded malicious content
- Generate random filenames (Laravel does this with `store()`, so you're fine)

### Mass-assignment
Your `$fillable` arrays look correct. Just remember: if you ever pass `$request->all()` to `Post::create()`, anything in `$fillable` can be set by the user — including `user_id` if you forget to overwrite it. Always be explicit:
```php
Post::create([
    'user_id' => auth()->id(),  // never trust the user for this
    ...$validated,
])
```

### Comments don't have a max length
Someone could submit a 10MB comment. Add `max:1000` to your validation.

### Profile image upload doesn't validate
In `ProfileController::update()`, there's no validation rule for `profile_image`. Add `'profile_image' => 'nullable|image|max:2048'`.

### No rate limiting
Anyone could spam-create 10,000 recipes or comments. Laravel has built-in throttle middleware:
```php
Route::middleware('throttle:30,1')->group(function () { ... });
```
Worth adding to write endpoints.

### CSRF is handled
Good news — Laravel handles this automatically as long as you have `@csrf` in your forms (which you do).

---

## 🏗️ Architectural suggestions for your next iteration

These aren't bugs — they're "ways the project will be more maintainable when it grows."

### Use Form Request classes
Right now, validation lives inline in the controller. Once your validation rules grow, extract them:
```bash
php artisan make:request StorePostRequest
```
This moves validation, authorization, and error messages into one dedicated class. Your controller becomes 3 lines.

### Use Laravel Policies for authorization
Instead of `abort_unless($post->isOwnedBy(...))`, register a `PostPolicy` and use:
```php
$this->authorize('update', $post);
```
It's cleaner, testable, and follows Laravel conventions.

### Use Resource Controllers properly
Right now you have `Route::get(...)`, `Route::post(...)` listed individually. For standard CRUD, you can use `Route::resource('posts', PostController::class)` which auto-generates all 7 routes following REST conventions. Combine with `->only([...])` or `->except([...])` if you don't want all of them.

### Service classes for complex logic
If `PostController::store` ever grows past ~50 lines, extract a `RecipeService` class. Controllers should be thin — they translate HTTP requests into actions, nothing more.

### Add tests
You have `tests/Feature` and `tests/Unit` directories with Laravel's defaults — but no real tests. Try writing one for "an authenticated user can create a recipe." That single test forces you to learn factories, the test database, and HTTP testing — which makes you a much better engineer.

```php
test('user can create a recipe', function () {
    $user = User::factory()->create();
    $response = $this->actingAs($user)
        ->post('/posts/store', [
            'title' => 'My recipe',
            'instructions' => 'Step one',
            'ingredients' => 'salt',
        ]);
    $response->assertRedirect();
    $this->assertDatabaseHas('posts', ['title' => 'My recipe']);
});
```

---

## 📚 What to learn next, in order

If you want a learning roadmap from where you are:

1. **Laravel Policies** — proper authorization (1 evening)
2. **Form Request classes** — clean validation (1 evening)
3. **Pest or PHPUnit testing** — write 5 tests for this app (1 weekend)
4. **Laravel Queues** — for things like sending emails async (1 evening + a real use case)
5. **Building a REST API** — convert this app's posts endpoint into a JSON API. Foundation for any future mobile app or SPA. (1 weekend)
6. **One frontend framework on top** — pick **either** Livewire (stays in PHP, smooth) **or** Vue/React with Inertia.js. Don't learn both at once.
7. **Deployment** — get this app live on a real URL. Try **Forge + DigitalOcean**, **Railway**, or **Fly.io**. Until you've deployed something, you haven't really finished it.

---

## 🎯 The honest summary

You are **further along than most people doing CS degrees in their second year**. You're past the "follow tutorials" stage and actually building things. The gaps in this project aren't gaps in your ability — they're gaps in exposure. You haven't yet been told that pagination matters, that authorization needs explicit checks, that READMEs are read by humans.

Keep building. Push this to GitHub. Add ratings or scaling-by-servings as a follow-up feature in a few weeks. Deploy it. Then build something completely different next.

You're doing well. 🍅
