@extends('layouts.main')
@section('title', 'All Recipes')

@section('content')
<div class="max-w-7xl mx-auto px-6 lg:px-8 py-10">

    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 mb-8">
        <div>
            <h1 class="font-serif text-4xl font-bold text-clay-500">
                @if(request('q'))
                    Results for "{{ request('q') }}"
                @elseif(request('tag'))
                    {{ request('tag') }} recipes
                @else
                    All recipes
                @endif
            </h1>
            <p class="text-clay-300 mt-1 text-sm">
                {{ $posts->total() }} {{ Str::plural('recipe', $posts->total()) }} found
            </p>
        </div>

        {{-- Search bar --}}
        <form action="{{ route('posts.index') }}" method="GET" class="relative md:w-80">
            <input type="search" name="q" value="{{ request('q') }}" placeholder="Search recipes..."
                   class="w-full pl-10 pr-4 py-2.5 bg-white border border-cream-200 rounded-full focus:outline-none focus:ring-2 focus:ring-terracotta-300 focus:border-transparent">
            <svg class="w-5 h-5 absolute left-3 top-1/2 -translate-y-1/2 text-clay-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            @if(request('tag'))
                <input type="hidden" name="tag" value="{{ request('tag') }}">
            @endif
        </form>
    </div>

    {{-- Tag filter chips --}}
    <div class="flex flex-wrap gap-2 mb-8">
        <a href="{{ route('posts.index', request()->only('q')) }}"
           class="px-4 py-1.5 rounded-full text-sm font-medium border transition
                  {{ !request('tag') ? 'bg-terracotta-500 text-white border-terracotta-500' : 'bg-white text-clay-400 border-cream-200 hover:border-terracotta-300' }}">
            All
        </a>
        @foreach($tags as $tag)
            <a href="{{ route('posts.index', array_merge(request()->only('q'), ['tag' => $tag->name])) }}"
               class="px-4 py-1.5 rounded-full text-sm font-medium border transition
                      {{ request('tag') === $tag->name ? 'bg-terracotta-500 text-white border-terracotta-500' : 'bg-white text-clay-400 border-cream-200 hover:border-terracotta-300' }}">
                {{ $tag->name }}
            </a>
        @endforeach
    </div>

    {{-- Recipes grid --}}
    @if($posts->count() === 0)
        <div class="text-center py-20">
            <div class="text-6xl mb-4">🍽️</div>
            <h3 class="font-serif text-2xl font-bold text-clay-500 mb-2">No recipes found</h3>
            <p class="text-clay-300 mb-6">Try a different search or category.</p>
            <a href="{{ route('posts.index') }}" class="inline-block px-6 py-2.5 bg-terracotta-500 hover:bg-terracotta-600 text-white rounded-full font-semibold transition">
                See all recipes
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($posts as $post)
                <a href="{{ route('posts.show', $post) }}"
                   class="group bg-white rounded-2xl overflow-hidden border border-cream-100 hover:border-terracotta-200 hover:shadow-warm-lg transition flex flex-col">

                    {{-- Image --}}
                    <div class="aspect-[4/3] overflow-hidden bg-cream-100 relative">
                        @if($post->image)
                            <img src="{{ Str::startsWith($post->image, 'http') ? $post->image : asset('storage/' . $post->image) }}"
                                 alt="{{ $post->title }}"
                                 class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-5xl">🍳</div>
                        @endif

                        @if($post->difficulty)
                            <span class="absolute top-3 left-3 bg-white/90 backdrop-blur px-2.5 py-1 rounded-full text-xs font-semibold text-clay-500">
                                {{ $post->difficulty }}
                            </span>
                        @endif

                        @if($post->total_time > 0)
                            <span class="absolute top-3 right-3 bg-white/90 backdrop-blur px-2.5 py-1 rounded-full text-xs font-semibold text-clay-500 flex items-center gap-1">
                                ⏱ {{ $post->total_time }}m
                            </span>
                        @endif
                    </div>

                    {{-- Content --}}
                    <div class="p-5 flex flex-col flex-grow">
                        <h2 class="font-serif text-xl font-bold text-clay-500 group-hover:text-terracotta-500 transition line-clamp-1">
                            {{ $post->title }}
                        </h2>
                        <p class="text-sm text-clay-300 mt-1.5 line-clamp-2 flex-grow">
                            {{ $post->description ?: 'A delicious recipe to try.' }}
                        </p>

                        {{-- Tags --}}
                        @if($post->tags->count())
                            <div class="flex flex-wrap gap-1 mt-3">
                                @foreach($post->tags->take(3) as $tag)
                                    <span class="text-xs px-2 py-0.5 rounded-full bg-cream-100 text-clay-400">{{ $tag->name }}</span>
                                @endforeach
                            </div>
                        @endif

                        {{-- Footer: author + stats --}}
                        <div class="flex items-center justify-between mt-4 pt-4 border-t border-cream-100">
                            <span class="text-xs text-clay-300 truncate">
                                by <span class="font-medium text-clay-400">{{ $post->author?->name ?? 'Unknown' }}</span>
                            </span>
                            <div class="flex items-center gap-3 text-xs text-clay-300">
                                <span class="flex items-center gap-1">❤ {{ $post->likes_count ?? 0 }}</span>
                                <span class="flex items-center gap-1">💬 {{ $post->comments_count ?? 0 }}</span>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="mt-10">
            {{ $posts->links() }}
        </div>
    @endif

</div>
@endsection
