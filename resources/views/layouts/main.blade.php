<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'TastyShare') · TastyShare</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@500;700&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex flex-col min-h-screen bg-cream-50 text-clay-500 font-sans antialiased">

    @include('parts.nav-bar')

    {{-- Flash messages --}}
    @if (session('success'))
        <div class="max-w-6xl mx-auto w-full px-6 mt-4">
            <div class="bg-terracotta-50 border border-terracotta-200 text-terracotta-700 px-4 py-3 rounded-lg shadow-warm">
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if ($errors->any())
        <div class="max-w-6xl mx-auto w-full px-6 mt-4">
            <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg shadow-warm">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <main class="flex-grow">
        @yield('content')
    </main>

    @include('parts.footer')

</body>
</html>
