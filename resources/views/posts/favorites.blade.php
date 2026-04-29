@extends('layouts.main')
@section('title', 'My favorites')

@section('content')
<div class="max-w-7xl mx-auto px-6 lg:px-8 py-10">

    <div class="mb-8">
        <h1 class="font-serif text-4xl font-bold text-clay-500 flex items-center gap-2">
            <span class="text-amber-500">★</span> My favorites
        </h1>
        <p class="text-clay-300 mt-1 text-sm">
            {{ $favorites->count() }} saved {{ Str::plural('recipe', $favorites->count()) }}
        </p>
    </div>

    @if($favorites->isEmpty())
        <div class="text-center py-20 bg-white rounded-3xl border border-cream-100">
            <div class="text-6xl mb-4">⭐</div>
            <h3 class="font-serif text-2xl font-bold text-clay-500 mb-2">No favorites yet</h3>
            <p class="text-clay-300 mb-6">Save recipes you love by tapping the star on any recipe.</p>
            <a href="{{ route('posts.index') }}"
               class="inline-block px-6 py-2.5 bg-terracotta-500 hover:bg-terracotta-600 text-white rounded-full font-semibold transition">
                Browse recipes
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($favorites as $post)
                @include('posts.partials.card', ['card' => $post])
            @endforeach
        </div>
    @endif

</div>
@endsection
