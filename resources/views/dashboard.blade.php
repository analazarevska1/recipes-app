@extends('layouts.main')
@section('title', 'Dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-6 lg:px-8 py-10">

    {{-- Profile header --}}
    <div class="bg-white border border-cream-100 rounded-3xl p-6 lg:p-8 shadow-warm flex flex-col md:flex-row gap-6 items-center md:items-start mb-10">
        <img src="{{ auth()->user()->profile_image_url }}" alt="{{ auth()->user()->name }}"
             class="w-24 h-24 rounded-full object-cover border-4 border-cream-100 shadow-warm">

        <div class="flex-grow text-center md:text-left">
            <h1 class="font-serif text-3xl font-bold text-clay-500">
                Welcome back, {{ auth()->user()->name }} 👋
            </h1>
            <p class="text-clay-300 text-sm mt-1">{{ auth()->user()->email }}</p>
            @if(auth()->user()->bio)
                <p class="text-clay-400 text-sm mt-3 max-w-xl">{{ auth()->user()->bio }}</p>
            @endif

            <div class="flex flex-wrap gap-2 mt-5 justify-center md:justify-start">
                <a href="{{ route('users.show', auth()->user()) }}"
                   class="px-4 py-2 text-sm font-semibold bg-cream-100 hover:bg-cream-200 text-clay-500 rounded-full transition">
                    View public profile
                </a>
                <a href="{{ route('profile.edit') }}"
                   class="px-4 py-2 text-sm font-semibold bg-cream-100 hover:bg-cream-200 text-clay-500 rounded-full transition">
                    Edit profile
                </a>
                <a href="{{ route('post.create') }}"
                   class="px-4 py-2 text-sm font-semibold bg-terracotta-500 hover:bg-terracotta-600 text-white rounded-full shadow-warm transition">
                    + New recipe
                </a>
            </div>
        </div>
    </div>

    {{-- My recipes --}}
    <div class="flex items-center justify-between mb-6">
        <h2 class="font-serif text-2xl font-bold text-clay-500">My recipes</h2>
        <p class="text-sm text-clay-300">{{ $posts->count() }} total</p>
    </div>

    @if($posts->isEmpty())
        <div class="text-center py-16 bg-white rounded-3xl border border-cream-100">
            <div class="text-6xl mb-4">📝</div>
            <h3 class="font-serif text-2xl font-bold text-clay-500 mb-2">No recipes yet</h3>
            <p class="text-clay-300 mb-6">Share your first one with the community.</p>
            <a href="{{ route('post.create') }}"
               class="inline-block px-6 py-2.5 bg-terracotta-500 hover:bg-terracotta-600 text-white rounded-full font-semibold transition">
                Create my first recipe
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($posts as $post)
                @include('posts.partials.card', ['card' => $post])
            @endforeach
        </div>
    @endif

</div>
@endsection
