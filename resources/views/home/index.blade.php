@extends('layouts.main')
@section('title', 'Home')

@section('content')
{{-- Hero --}}
<section class="relative overflow-hidden">
    <div class="absolute inset-0 bg-gradient-to-br from-cream-100 via-cream-50 to-terracotta-50"></div>

    <div class="relative max-w-7xl mx-auto px-6 lg:px-8 py-20 lg:py-28 grid lg:grid-cols-2 gap-12 items-center">
        <div class="space-y-6">
            <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-terracotta-100 text-terracotta-700 text-xs font-semibold tracking-wide uppercase">
                ✨ Cook · Share · Inspire
            </span>
            <h1 class="font-serif text-5xl lg:text-6xl font-bold leading-tight text-clay-500">
                Real recipes from <br>
                <span class="text-terracotta-500">real home cooks.</span>
            </h1>
            <p class="text-lg text-clay-400 max-w-md leading-relaxed">
                Discover something delicious to make tonight, save your favourites,
                and share the dishes you love with a warm community of food lovers.
            </p>
            <div class="flex flex-wrap gap-3 pt-2">
                <a href="{{ route('posts.index') }}"
                   class="px-6 py-3 bg-terracotta-500 hover:bg-terracotta-600 text-white font-semibold rounded-full shadow-warm-lg transition">
                    Browse recipes
                </a>
                @guest
                <a href="{{ route('register') }}"
                   class="px-6 py-3 bg-white border border-cream-200 hover:border-terracotta-300 text-clay-500 font-semibold rounded-full transition">
                    Join free
                </a>
                @else
                <a href="{{ route('post.create') }}"
                   class="px-6 py-3 bg-white border border-cream-200 hover:border-terracotta-300 text-clay-500 font-semibold rounded-full transition">
                    Share your recipe
                </a>
                @endguest
            </div>
        </div>

        <div class="relative">
            <div class="aspect-[4/5] rounded-3xl overflow-hidden shadow-warm-lg">
                <img src="https://images.unsplash.com/photo-1540189549336-e6e99c3679fe?w=900&q=80"
                     alt="Fresh ingredients" class="w-full h-full object-cover">
            </div>
            <div class="absolute -bottom-6 -left-6 bg-white rounded-2xl p-4 shadow-warm-lg flex items-center gap-3 border border-cream-100">
                <div class="text-3xl">🥗</div>
                <div>
                    <p class="text-xs text-clay-300 font-medium">Trending today</p>
                    <p class="text-sm font-semibold text-clay-500">Mediterranean bowls</p>
                </div>
            </div>
            <div class="absolute -top-6 -right-6 bg-white rounded-2xl p-4 shadow-warm-lg flex items-center gap-3 border border-cream-100">
                <div class="text-3xl">⏱️</div>
                <div>
                    <p class="text-xs text-clay-300 font-medium">Quick &amp; easy</p>
                    <p class="text-sm font-semibold text-clay-500">Under 20 minutes</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Categories strip --}}
<section class="max-w-7xl mx-auto px-6 lg:px-8 py-16">
    <h2 class="font-serif text-3xl font-bold text-clay-500 mb-8 text-center">Browse by category</h2>
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
        @foreach ([
            ['Breakfast', '🥞'],
            ['Lunch', '🥗'],
            ['Dinner', '🍝'],
            ['Snack', '🥨'],
            ['Dessert', '🍰'],
            ['Vegan', '🌱'],
        ] as [$name, $emoji])
        <a href="{{ route('posts.index', ['tag' => $name]) }}"
           class="group bg-white rounded-2xl p-6 text-center border border-cream-100 hover:border-terracotta-300 hover:shadow-warm transition">
            <div class="text-4xl mb-2 group-hover:scale-110 transition">{{ $emoji }}</div>
            <p class="font-semibold text-clay-500">{{ $name }}</p>
        </a>
        @endforeach
    </div>
</section>

{{-- Welcome / about --}}
<section class="bg-cream-100 py-16">
    <div class="max-w-4xl mx-auto px-6 text-center">
        <span class="text-terracotta-500 font-semibold uppercase tracking-wide text-sm">Welcome</span>
        <h2 class="font-serif text-3xl lg:text-4xl font-bold text-clay-500 mt-2 mb-4">
            A community for people who love food
        </h2>
        <p class="text-clay-400 leading-relaxed">
            TastyShare is where home cooks gather to share what they love.
            Whether you’re after a quick weekday breakfast, a comforting dinner,
            or a show-stopping dessert, you’ll find something here that makes you hungry.
            Save what you like, leave a kind comment, and post your own recipes when you’re ready.
        </p>
    </div>
</section>

@endsection
