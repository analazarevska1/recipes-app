# 🚨 Setup notes — read this first!

These are the steps you need to run after replacing your old project with this one. Do them in order.

---

## 1. Run the new database migration

I added a migration for two new fields on the `posts` table: `difficulty` and `slug`. Run:

```bash
php artisan migrate
```

If something goes wrong (rare, but possible if your DB has weird state), you can do a clean reset:
```bash
php artisan migrate:fresh
php artisan db:seed --class=TagSeeder
```
**⚠️ Warning:** `migrate:fresh` deletes ALL existing data. Only do this if you're OK starting over (you'll lose existing test recipes).

---

## 2. Rebuild Vite assets (very important!)

The old project used Tailwind via CDN inside `main.blade.php`. I removed that and switched to Vite (the proper way). For your styles to show up, you **must** build the assets:

**For development:**
```bash
npm install   # if you haven't already
npm run dev
```
Leave this running in a terminal — it watches for changes and hot-reloads.

**For production / deployed builds:**
```bash
npm run build
```

If you see an unstyled page (looks like raw HTML), it's because the assets haven't been built yet.

---

## 3. Make sure storage is linked

If you haven't already done this, run:
```bash
php artisan storage:link
```
This creates a symlink from `public/storage` → `storage/app/public` so uploaded images can be served.

---

## 4. Clear caches (just in case)

If anything looks weird (old views being served, routes not found), clear the caches:
```bash
php artisan view:clear
php artisan route:clear
php artisan config:clear
php artisan cache:clear
```

---

## 5. New URLs that now work

After this update, these new pages exist:

- `/posts/{post}/edit` — edit a recipe (auth + ownership required)
- `/posts/{post}/print` — print-friendly view
- `/posts/{post}/print?list=1` — shopping list only
- `/users/{user}` — public user profile
- `/posts?q=pasta` — search
- `/posts?tag=Vegan` — filter by tag

---

## 6. Things to verify after setup

A quick checklist to make sure nothing broke:

- [ ] Home page loads with the warm cream/orange colors
- [ ] You can register a new account
- [ ] You can create a recipe (test the difficulty dropdown!)
- [ ] You can edit a recipe you own
- [ ] You **cannot** edit someone else's recipe (try going to `/posts/{their_post_id}/edit` — should give 403)
- [ ] Search works (`/posts?q=something`)
- [ ] Print mode opens in a new tab
- [ ] Profile images display correctly
- [ ] Mobile menu works on small screens

---

## 7. Before pushing to GitHub

Make sure you've created a `.gitkeep` file in `storage/logs/` so the directory exists in the repo:

```bash
touch storage/logs/.gitkeep
```

Otherwise `composer install` on a fresh clone might fail if the directory doesn't exist.

Also, **check your `.env` file is NOT being committed** (it's in `.gitignore`, but verify with `git status` before your first commit). It may contain sensitive keys.

---

## 8. Recommended GitHub repo setup

When you create the repo:
1. Make it **public** (so recruiters can see it)
2. Repo name: `tastyshare` or `recipes-app`
3. Description: `Recipe sharing platform built with Laravel & Tailwind`
4. Add topics: `laravel`, `php`, `tailwindcss`, `alpinejs`
5. After pushing, add a screenshot or two to the README
6. **Pin this repo** on your GitHub profile

Good luck! 🍅
