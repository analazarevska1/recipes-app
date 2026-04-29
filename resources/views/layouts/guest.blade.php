<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'TastyShare') }}</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@500;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen flex flex-col items-center justify-center bg-gradient-to-br from-cream-100 via-cream-50 to-terracotta-50 p-6">
        <a href="{{ route('index') }}" class="flex items-center gap-2 mb-8">
            <span class="text-3xl">🍅</span>
            <span class="font-serif text-3xl font-bold text-terracotta-500">TastyShare</span>
        </a>

        <div class="w-full sm:max-w-md bg-white rounded-3xl shadow-warm-lg border border-cream-100 p-8">
            {{ $slot }}
        </div>

        <a href="{{ route('index') }}" class="mt-6 text-sm text-clay-300 hover:text-terracotta-500 transition">
            ← Back to home
        </a>
    </div>
</body>
</html>
