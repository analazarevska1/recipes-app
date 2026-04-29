@extends('layouts.main')
@section('title', $user->name)

@section('content')
<div class="max-w-7xl mx-auto px-6 lg:px-8 py-10">

    {{-- Profile header --}}
    <div class="relative">
        <div class="h-40 bg-gradient-to-br from-terracotta-200 via-cream-200 to-cream-100 rounded-3xl"></div>

        <div class="-mt-16 px-6 lg:px-10">
            <div class="flex flex-col md:flex-row md:items-end gap-4">
                <img src="{{ $user->profile_image_url }}" alt="{{ $user->name }}"
                     class="w-32 h-32 rounded-full object-cover border-4 border-cream-50 shadow-warm-lg bg-white">

                <div class="flex-grow">
                    <h1 class="font-serif text-3xl font-bold text-clay-500">{{ $user->name }}</h1>
                    @if($user->location)
                        <p class="text-clay-300 text-sm flex items-center gap-1 mt-1">
                            📍 {{ $user->location }}
                        </p>
                    @endif
                    @if($user->bio)
                        <p class="text-clay-400 text-sm mt-2 max-w-2xl">{{ $user->bio }}</p>
                    @endif
                </div>

                @auth
                    @if(auth()->id() === $user->id)
                        <a href="{{ route('profile.edit') }}"
                           class="px-4 py-2 text-sm font-semibold bg-white border border-cream-200 hover:border-terracotta-300 text-clay-500 rounded-full transition">
                            Edit profile
                        </a>
                    @endif
                @endauth
            </div>
        </div>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-3 gap-4 mt-8 max-w-md">
        <div class="bg-white border border-cream-100 rounded-2xl p-4 text-center">
            <p class="font-serif text-2xl font-bold text-terracotta-500">{{ $stats['recipes'] }}</p>
            <p class="text-xs text-clay-300 uppercase tracking-wide font-semibold mt-1">Recipes</p>
        </div>
        <div class="bg-white border border-cream-100 rounded-2xl p-4 text-center">
            <p class="font-serif text-2xl font-bold text-terracotta-500">{{ $stats['likes'] }}</p>
            <p class="text-xs text-clay-300 uppercase tracking-wide font-semibold mt-1">Likes received</p>
        </div>
        <div class="bg-white border border-cream-100 rounded-2xl p-4 text-center">
            <p class="font-serif text-2xl font-bold text-terracotta-500">{{ $stats['favorites'] }}</p>
            <p class="text-xs text-clay-300 uppercase tracking-wide font-semibold mt-1">Saves</p>
        </div>
    </div>

    {{-- Recipes --}}
    <div class="mt-12">
        <h2 class="font-serif text-2xl font-bold text-clay-500 mb-6">
            {{ $user->name }}'s recipes
        </h2>

        @if($posts->isEmpty())
            <div class="text-center py-16 bg-white rounded-3xl border border-cream-100">
                <div class="text-5xl mb-3">🍽️</div>
                <p class="text-clay-400">No recipes shared yet.</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($posts as $post)
                    @include('posts.partials.card', ['card' => $post])
                @endforeach
            </div>

            <div class="mt-10">{{ $posts->links() }}</div>
        @endif
    </div>

</div>
@endsection
