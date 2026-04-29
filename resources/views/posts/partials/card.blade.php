@php
    /** @var \App\Models\Post $card */
    $card = $card ?? null;
@endphp

<a href="{{ route('posts.show', $card) }}"
   class="group bg-white rounded-2xl overflow-hidden border border-cream-100 hover:border-terracotta-200 hover:shadow-warm-lg transition flex flex-col">

    <div class="aspect-[4/3] overflow-hidden bg-cream-100 relative">
        @if($card->image)
            <img src="{{ Str::startsWith($card->image, 'http') ? $card->image : asset('storage/' . $card->image) }}"
                 alt="{{ $card->title }}"
                 class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
        @else
            <div class="w-full h-full flex items-center justify-center text-5xl">🍳</div>
        @endif

        @if(!empty($card->difficulty))
            <span class="absolute top-3 left-3 bg-white/90 backdrop-blur px-2.5 py-1 rounded-full text-xs font-semibold text-clay-500">
                {{ $card->difficulty }}
            </span>
        @endif

        @if($card->total_time > 0)
            <span class="absolute top-3 right-3 bg-white/90 backdrop-blur px-2.5 py-1 rounded-full text-xs font-semibold text-clay-500 flex items-center gap-1">
                ⏱ {{ $card->total_time }}m
            </span>
        @endif
    </div>

    <div class="p-5 flex flex-col flex-grow">
        <h2 class="font-serif text-xl font-bold text-clay-500 group-hover:text-terracotta-500 transition line-clamp-1">
            {{ $card->title }}
        </h2>
        <p class="text-sm text-clay-300 mt-1.5 line-clamp-2 flex-grow">
            {{ $card->description ?: 'A delicious recipe to try.' }}
        </p>

        @if($card->tags && $card->tags->count())
            <div class="flex flex-wrap gap-1 mt-3">
                @foreach($card->tags->take(3) as $tag)
                    <span class="text-xs px-2 py-0.5 rounded-full bg-cream-100 text-clay-400">{{ $tag->name }}</span>
                @endforeach
            </div>
        @endif

        <div class="flex items-center justify-between mt-4 pt-4 border-t border-cream-100">
            <span class="text-xs text-clay-300 truncate">
                @isset($card->author)
                    by <span class="font-medium text-clay-400">{{ $card->author?->name ?? 'Unknown' }}</span>
                @endisset
            </span>
            <div class="flex items-center gap-3 text-xs text-clay-300">
                <span class="flex items-center gap-1">❤ {{ $card->likes_count ?? $card->likes?->count() ?? 0 }}</span>
                <span class="flex items-center gap-1">💬 {{ $card->comments_count ?? $card->comments?->count() ?? 0 }}</span>
            </div>
        </div>
    </div>
</a>
