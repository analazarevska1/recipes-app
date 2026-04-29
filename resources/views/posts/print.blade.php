<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $post->title }} — Print</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@500;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .serif { font-family: 'Playfair Display', serif; }
        @media print {
            .no-print { display: none !important; }
            body { padding: 0 !important; }
            .page { box-shadow: none !important; border: none !important; padding: 0 !important; }
            a { color: #000 !important; text-decoration: none !important; }
        }
    </style>
</head>
<body class="bg-gray-100 p-6 text-gray-800">

    @php $shoppingOnly = request('list') === '1'; @endphp

    <div class="page max-w-3xl mx-auto bg-white p-10 shadow-md border border-gray-200 rounded-lg">

        {{-- Print bar --}}
        <div class="no-print flex justify-between items-center mb-6 pb-4 border-b">
            <a href="{{ route('posts.show', $post) }}" class="text-sm text-gray-500 hover:underline">← Back to recipe</a>
            <button onclick="window.print()" class="px-4 py-2 bg-orange-600 text-white text-sm font-semibold rounded-lg hover:bg-orange-700">
                🖨 Print this page
            </button>
        </div>

        @if($shoppingOnly)
            {{-- Shopping list mode --}}
            <h1 class="serif text-3xl font-bold mb-1">Shopping list</h1>
            <p class="text-sm text-gray-500 mb-6">For: <span class="font-semibold">{{ $post->title }}</span>
                @if($post->servings) · {{ $post->servings }} servings @endif
            </p>
            <ul class="space-y-3">
                @foreach (array_filter(array_map('trim', explode(',', $post->ingredients))) as $ingredient)
                    <li class="flex items-start gap-3 border-b border-dashed border-gray-200 pb-2">
                        <span class="inline-block w-5 h-5 border-2 border-gray-400 rounded mt-0.5"></span>
                        <span>{{ $ingredient }}</span>
                    </li>
                @endforeach
            </ul>
        @else
            {{-- Full recipe --}}
            <header class="mb-6 pb-6 border-b">
                <h1 class="serif text-4xl font-bold">{{ $post->title }}</h1>
                @if($post->description)
                    <p class="text-gray-600 mt-2">{{ $post->description }}</p>
                @endif
                <p class="text-sm text-gray-500 mt-3">
                    By {{ $post->author?->name ?? 'Unknown' }}
                    @if($post->tags->count())
                        · {{ $post->tags->pluck('name')->join(', ') }}
                    @endif
                </p>
            </header>

            <div class="grid grid-cols-4 gap-4 mb-6 text-center text-sm">
                <div class="border rounded-lg p-3"><p class="text-xs text-gray-500 uppercase">Prep</p><p class="font-bold text-lg">{{ $post->prep_time ?? '—' }}m</p></div>
                <div class="border rounded-lg p-3"><p class="text-xs text-gray-500 uppercase">Cook</p><p class="font-bold text-lg">{{ $post->cook_time ?? '—' }}m</p></div>
                <div class="border rounded-lg p-3"><p class="text-xs text-gray-500 uppercase">Servings</p><p class="font-bold text-lg">{{ $post->servings ?? '—' }}</p></div>
                <div class="border rounded-lg p-3"><p class="text-xs text-gray-500 uppercase">Difficulty</p><p class="font-bold text-lg">{{ $post->difficulty ?? '—' }}</p></div>
            </div>

            <section class="mb-6">
                <h2 class="serif text-2xl font-bold mb-3">Ingredients</h2>
                <ul class="space-y-1.5 text-sm pl-5 list-disc">
                    @foreach (array_filter(array_map('trim', explode(',', $post->ingredients))) as $ingredient)
                        <li>{{ $ingredient }}</li>
                    @endforeach
                </ul>
            </section>

            <section>
                <h2 class="serif text-2xl font-bold mb-3">Instructions</h2>
                <ol class="space-y-3 text-sm">
                    @foreach (array_filter(array_map('trim', explode("\n", $post->instructions))) as $i => $step)
                        <li class="flex gap-3">
                            <span class="font-bold serif text-lg">{{ $i + 1 }}.</span>
                            <span class="pt-0.5">{{ $step }}</span>
                        </li>
                    @endforeach
                </ol>
            </section>

            <footer class="mt-10 pt-4 border-t text-center text-xs text-gray-400">
                Printed from TastyShare · {{ now()->format('M j, Y') }}
            </footer>
        @endif
    </div>
</body>
</html>
