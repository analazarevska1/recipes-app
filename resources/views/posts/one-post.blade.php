@extends('layouts.main')
@section('title', $post->title)

@section('content')
<article class="max-w-6xl mx-auto px-6 lg:px-8 py-8 lg:py-12">

    {{-- Hero image + title --}}
    <header class="mb-8">
        <div class="aspect-[16/9] rounded-3xl overflow-hidden bg-cream-100 shadow-warm-lg">
            @if($post->image)
                <img src="{{ Str::startsWith($post->image, 'http') ? $post->image : asset('storage/' . $post->image) }}"
                     alt="{{ $post->title }}" class="w-full h-full object-cover">
            @else
                <div class="w-full h-full flex items-center justify-center text-8xl">🍳</div>
            @endif
        </div>

        <div class="mt-8 grid lg:grid-cols-3 gap-6 lg:items-end">
            <div class="lg:col-span-2 space-y-3">
                {{-- Tags --}}
                @if($post->tags->count())
                    <div class="flex flex-wrap gap-2">
                        @foreach($post->tags as $tag)
                            <a href="{{ route('posts.index', ['tag' => $tag->name]) }}"
                               class="text-xs px-3 py-1 rounded-full bg-terracotta-100 text-terracotta-700 hover:bg-terracotta-200 transition">
                                {{ $tag->name }}
                            </a>
                        @endforeach
                    </div>
                @endif

                <h1 class="font-serif text-4xl lg:text-5xl font-bold text-clay-500 leading-tight">
                    {{ $post->title }}
                </h1>
                @if($post->description)
                    <p class="text-lg text-clay-400 leading-relaxed">{{ $post->description }}</p>
                @endif

                {{-- Author --}}
                <a href="{{ route('users.show', $post->author) }}" class="inline-flex items-center gap-3 mt-3 group">
                    <img src="{{ $post->author?->profile_image_url }}" alt="{{ $post->author?->name }}"
                         class="w-10 h-10 rounded-full object-cover border-2 border-cream-200">
                    <div>
                        <p class="text-xs text-clay-300">By</p>
                        <p class="font-semibold text-clay-500 group-hover:text-terracotta-500 transition">
                            {{ $post->author?->name ?? 'Unknown' }}
                        </p>
                    </div>
                </a>
            </div>

            {{-- Action buttons --}}
            <div class="flex flex-wrap gap-2 lg:justify-end">
                @auth
                    <form action="{{ route('post.like', $post) }}" method="POST">
                        @csrf
                        <button type="submit"
                                class="px-4 py-2.5 rounded-full bg-white border border-cream-200 hover:border-terracotta-300 transition flex items-center gap-2 text-sm font-semibold text-clay-500">
                            @if($post->likes->contains(auth()->id()))
                                <span class="text-red-500">❤</span>
                            @else
                                <span class="text-clay-300">♡</span>
                            @endif
                            <span>{{ $post->likes->count() }}</span>
                        </button>
                    </form>

                    <form action="{{ route('post.favorite', $post) }}" method="POST">
                        @csrf
                        <button type="submit"
                                class="px-4 py-2.5 rounded-full bg-white border border-cream-200 hover:border-terracotta-300 transition flex items-center gap-2 text-sm font-semibold text-clay-500">
                            @if($post->favorites->contains(auth()->id()))
                                <span class="text-amber-500">★</span> <span>Saved</span>
                            @else
                                <span class="text-clay-300">☆</span> <span>Save</span>
                            @endif
                        </button>
                    </form>
                @endauth

                <a href="{{ route('posts.print', $post) }}" target="_blank"
                   class="px-4 py-2.5 rounded-full bg-white border border-cream-200 hover:border-terracotta-300 transition flex items-center gap-2 text-sm font-semibold text-clay-500">
                    🖨 Print
                </a>

                @auth
                    @if($post->isOwnedBy(auth()->user()))
                        <a href="{{ route('posts.edit', $post) }}"
                           class="px-4 py-2.5 rounded-full bg-clay-500 hover:bg-clay-400 text-white transition flex items-center gap-2 text-sm font-semibold">
                            ✏ Edit
                        </a>
                        <form action="{{ route('posts.destroy', $post) }}" method="POST"
                              onsubmit="return confirm('Delete this recipe? This cannot be undone.')">
                            @csrf @method('DELETE')
                            <button class="px-4 py-2.5 rounded-full bg-red-500 hover:bg-red-600 text-white transition flex items-center gap-2 text-sm font-semibold">
                                🗑 Delete
                            </button>
                        </form>
                    @endif
                @endauth
            </div>
        </div>
    </header>

    {{-- Quick stats strip --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-10">
        <div class="bg-cream-100 rounded-xl p-4 text-center">
            <p class="text-xs text-clay-300 uppercase tracking-wide font-semibold">Prep</p>
            <p class="font-serif text-xl font-bold text-clay-500 mt-1">{{ $post->prep_time ?? '—' }} <span class="text-sm font-normal">min</span></p>
        </div>
        <div class="bg-cream-100 rounded-xl p-4 text-center">
            <p class="text-xs text-clay-300 uppercase tracking-wide font-semibold">Cook</p>
            <p class="font-serif text-xl font-bold text-clay-500 mt-1">{{ $post->cook_time ?? '—' }} <span class="text-sm font-normal">min</span></p>
        </div>
        <div class="bg-cream-100 rounded-xl p-4 text-center">
            <p class="text-xs text-clay-300 uppercase tracking-wide font-semibold">Servings</p>
            <p class="font-serif text-xl font-bold text-clay-500 mt-1">{{ $post->servings ?? '—' }}</p>
        </div>
        <div class="bg-cream-100 rounded-xl p-4 text-center">
            <p class="text-xs text-clay-300 uppercase tracking-wide font-semibold">Difficulty</p>
            <p class="font-serif text-xl font-bold text-clay-500 mt-1">{{ $post->difficulty ?? '—' }}</p>
        </div>
    </div>

    {{-- Body: ingredients + instructions + comments --}}
    <div class="grid lg:grid-cols-3 gap-8">

        {{-- Ingredients --}}
        <aside class="lg:col-span-1">
            <div class="bg-white border border-cream-100 rounded-2xl p-6 sticky top-24">
                <h2 class="font-serif text-2xl font-bold text-clay-500 mb-4 flex items-center gap-2">
                    🥘 Ingredients
                </h2>
                <ul class="space-y-2.5" x-data="{}">
                    @foreach (array_filter(array_map('trim', explode(',', $post->ingredients))) as $ingredient)
                        <li class="flex items-start gap-3 text-sm text-clay-500">
                            <input type="checkbox" class="mt-1 rounded border-cream-300 text-terracotta-500 focus:ring-terracotta-300">
                            <span>{{ $ingredient }}</span>
                        </li>
                    @endforeach
                </ul>

                {{-- Shopping list button --}}
                <a href="{{ route('posts.print', $post) }}?list=1" target="_blank"
                   class="mt-6 block text-center w-full px-4 py-2.5 bg-cream-100 hover:bg-cream-200 text-clay-500 font-semibold rounded-xl transition text-sm">
                    🛒 Print shopping list
                </a>
            </div>
        </aside>

        {{-- Instructions + comments --}}
        <div class="lg:col-span-2 space-y-10">

            {{-- Instructions --}}
            <section>
                <h2 class="font-serif text-2xl font-bold text-clay-500 mb-5 flex items-center gap-2">
                    👩‍🍳 Instructions
                </h2>
                <ol class="space-y-4">
                    @foreach (array_filter(array_map('trim', explode("\n", $post->instructions))) as $i => $step)
                        <li class="flex gap-4">
                            <span class="flex-shrink-0 w-9 h-9 rounded-full bg-terracotta-500 text-white font-serif font-bold flex items-center justify-center text-lg">
                                {{ $i + 1 }}
                            </span>
                            <p class="pt-1.5 text-clay-500 leading-relaxed">{{ $step }}</p>
                        </li>
                    @endforeach
                </ol>
            </section>

            {{-- Comments --}}
            <section>
                <h2 class="font-serif text-2xl font-bold text-clay-500 mb-5 flex items-center gap-2">
                    💬 Comments
                    <span class="text-sm font-sans font-medium text-clay-300">({{ $post->comments->count() }})</span>
                </h2>

                @auth
                    <form action="{{ route('comment.save', $post) }}" method="POST" class="mb-6">
                        @csrf
                        <div class="flex gap-3 items-start">
                            <img src="{{ auth()->user()->profile_image_url }}" alt="{{ auth()->user()->name }}"
                                 class="w-10 h-10 rounded-full object-cover border-2 border-cream-200 flex-shrink-0">
                            <div class="flex-grow">
                                <textarea name="comment_text" required rows="2" placeholder="Share your thoughts..."
                                       class="w-full px-4 py-2.5 bg-white border border-cream-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-terracotta-300 focus:border-transparent resize-none"></textarea>
                                <button type="submit"
                                        class="mt-2 px-5 py-2 bg-terracotta-500 hover:bg-terracotta-600 text-white text-sm font-semibold rounded-full shadow-warm transition">
                                    Post comment
                                </button>
                            </div>
                        </div>
                    </form>
                @else
                    <div class="bg-cream-100 rounded-xl p-4 mb-6 text-sm text-clay-400">
                        <a href="{{ route('login') }}" class="text-terracotta-500 font-semibold hover:underline">Log in</a>
                        to leave a comment.
                    </div>
                @endauth

                @if($post->comments->isEmpty())
                    <p class="text-clay-300 italic text-sm">No comments yet — be the first to share!</p>
                @else
                    <div class="space-y-4">
                        @foreach($post->comments as $comment)
                            <div class="flex gap-3 group">
                                <img src="{{ $comment->user?->profile_image_url ?? 'https://cdn.pixabay.com/photo/2015/10/05/22/37/blank-profile-picture-973460_1280.png' }}"
                                     alt="{{ $comment->user?->name }}"
                                     class="w-10 h-10 rounded-full object-cover border-2 border-cream-200 flex-shrink-0">
                                <div class="flex-grow bg-white border border-cream-100 rounded-2xl px-4 py-3">
                                    <div class="flex items-center justify-between gap-2 mb-1">
                                        <a href="{{ route('users.show', $comment->user) }}" class="font-semibold text-sm text-clay-500 hover:text-terracotta-500 transition">
                                            {{ $comment->user?->name ?? 'Unknown' }}
                                        </a>
                                        <span class="text-xs text-clay-300">{{ $comment->created_at->diffForHumans() }}</span>
                                    </div>
                                    <p class="text-sm text-clay-500 leading-relaxed">{{ $comment->comment }}</p>

                                    @if(auth()->id() === $comment->user_id)
                                        <form action="{{ route('comment.destroy', $comment) }}" method="POST" class="mt-1">
                                            @csrf @method('DELETE')
                                            <button class="text-xs text-red-500 hover:text-red-700 opacity-0 group-hover:opacity-100 transition">
                                                Delete
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </section>
        </div>
    </div>
</article>
@endsection
