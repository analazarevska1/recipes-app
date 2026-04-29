<nav x-data="{ open: false, categoriesOpen: false, userMenuOpen: false }"
     class="bg-cream-50/90 backdrop-blur border-b border-cream-200 sticky top-0 z-40">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">

            {{-- Logo --}}
            <a href="{{ route('index') }}" class="flex items-center gap-2 group">
                <span class="text-2xl">🍅</span>
                <span class="font-serif text-2xl font-bold text-terracotta-500 group-hover:text-terracotta-600 transition">
                    TastyShare
                </span>
            </a>

            {{-- Desktop links --}}
            <div class="hidden md:flex items-center gap-1 text-sm font-medium">
                <a href="{{ route('index') }}"
                   class="px-3 py-2 rounded-lg hover:bg-cream-100 hover:text-terracotta-500 transition">Home</a>
                <a href="{{ route('posts.index') }}"
                   class="px-3 py-2 rounded-lg hover:bg-cream-100 hover:text-terracotta-500 transition">All Recipes</a>

                {{-- Categories dropdown --}}
                <div class="relative" @click.away="categoriesOpen = false">
                    <button @click="categoriesOpen = !categoriesOpen"
                            class="px-3 py-2 rounded-lg hover:bg-cream-100 hover:text-terracotta-500 transition flex items-center gap-1">
                        Categories
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="categoriesOpen" x-transition x-cloak
                         class="absolute mt-2 left-0 w-44 bg-white rounded-xl shadow-warm-lg border border-cream-200 py-2 overflow-hidden">
                        @foreach (['Breakfast','Lunch','Dinner','Snack','Dessert','Vegetarian','Vegan'] as $cat)
                            <a href="{{ route('posts.index', ['tag' => $cat]) }}"
                               class="block px-4 py-2 text-sm hover:bg-cream-100 hover:text-terracotta-500 transition">{{ $cat }}</a>
                        @endforeach
                    </div>
                </div>

                @auth
                    <a href="{{ route('favorite.index') }}"
                       class="px-3 py-2 rounded-lg hover:bg-cream-100 hover:text-terracotta-500 transition">Favorites</a>
                @endauth
            </div>

            {{-- Right side: search + auth --}}
            <div class="hidden md:flex items-center gap-3">
                <form action="{{ route('posts.index') }}" method="GET" class="relative">
                    <input type="search" name="q" value="{{ request('q') }}" placeholder="Search recipes..."
                           class="w-56 pl-9 pr-3 py-2 text-sm bg-white border border-cream-200 rounded-full focus:outline-none focus:ring-2 focus:ring-terracotta-300 focus:border-transparent">
                    <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-clay-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </form>

                @auth
                    <a href="{{ route('post.create') }}"
                       class="px-4 py-2 text-sm font-semibold bg-terracotta-500 text-white rounded-full hover:bg-terracotta-600 shadow-warm transition">
                        + Share recipe
                    </a>

                    <div class="relative" @click.away="userMenuOpen = false">
                        <button @click="userMenuOpen = !userMenuOpen" class="flex items-center gap-2 group">
                            <img src="{{ auth()->user()->profile_image_url }}"
                                 alt="{{ auth()->user()->name }}"
                                 class="w-9 h-9 rounded-full object-cover border-2 border-cream-200 group-hover:border-terracotta-300 transition">
                        </button>
                        <div x-show="userMenuOpen" x-transition x-cloak
                             class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-warm-lg border border-cream-200 py-2">
                            <div class="px-4 py-2 border-b border-cream-100">
                                <p class="text-sm font-semibold text-clay-500 truncate">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-clay-300 truncate">{{ auth()->user()->email }}</p>
                            </div>
                            <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm hover:bg-cream-100 transition">Dashboard</a>
                            <a href="{{ route('users.show', auth()->user()) }}" class="block px-4 py-2 text-sm hover:bg-cream-100 transition">My public profile</a>
                            <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm hover:bg-cream-100 transition">Edit profile</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition">
                                    Log out
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}"
                       class="px-4 py-2 text-sm font-semibold text-terracotta-600 hover:text-terracotta-700 transition">Log in</a>
                    <a href="{{ route('register') }}"
                       class="px-4 py-2 text-sm font-semibold bg-terracotta-500 text-white rounded-full hover:bg-terracotta-600 shadow-warm transition">
                        Sign up
                    </a>
                @endauth
            </div>

            {{-- Mobile menu button --}}
            <button @click="open = !open" class="md:hidden p-2 rounded-lg hover:bg-cream-100">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    <path x-show="open" x-cloak stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        {{-- Mobile menu --}}
        <div x-show="open" x-transition x-cloak class="md:hidden pb-4 space-y-2">
            <form action="{{ route('posts.index') }}" method="GET" class="relative">
                <input type="search" name="q" value="{{ request('q') }}" placeholder="Search recipes..."
                       class="w-full pl-9 pr-3 py-2 text-sm bg-white border border-cream-200 rounded-full focus:outline-none focus:ring-2 focus:ring-terracotta-300">
                <svg class="w-4 h-4 absolute left-3 top-1/2 -translate-y-1/2 text-clay-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </form>
            <a href="{{ route('index') }}" class="block px-3 py-2 rounded-lg hover:bg-cream-100">Home</a>
            <a href="{{ route('posts.index') }}" class="block px-3 py-2 rounded-lg hover:bg-cream-100">All Recipes</a>
            @auth
                <a href="{{ route('favorite.index') }}" class="block px-3 py-2 rounded-lg hover:bg-cream-100">Favorites</a>
                <a href="{{ route('post.create') }}" class="block px-3 py-2 rounded-lg bg-terracotta-500 text-white text-center font-semibold">+ Share recipe</a>
                <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded-lg hover:bg-cream-100">Dashboard</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="w-full text-left px-3 py-2 rounded-lg text-red-600 hover:bg-red-50">Log out</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="block px-3 py-2 rounded-lg hover:bg-cream-100">Log in</a>
                <a href="{{ route('register') }}" class="block px-3 py-2 rounded-lg bg-terracotta-500 text-white text-center font-semibold">Sign up</a>
            @endauth
        </div>
    </div>
</nav>

<style>[x-cloak] { display: none !important; }</style>
