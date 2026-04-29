<x-guest-layout>
    <h1 class="font-serif text-3xl font-bold text-clay-500 mb-1 text-center">Welcome back</h1>
    <p class="text-clay-300 text-sm mb-6 text-center">Log in to share and save recipes.</p>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <div>
            <label for="email" class="block text-sm font-semibold text-clay-500 mb-1.5">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                   class="w-full px-4 py-2.5 bg-cream-50 border border-cream-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-terracotta-300 focus:border-transparent">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <label for="password" class="block text-sm font-semibold text-clay-500 mb-1.5">Password</label>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                   class="w-full px-4 py-2.5 bg-cream-50 border border-cream-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-terracotta-300 focus:border-transparent">
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between text-sm">
            <label class="inline-flex items-center">
                <input type="checkbox" name="remember"
                       class="rounded border-cream-300 text-terracotta-500 focus:ring-terracotta-300">
                <span class="ml-2 text-clay-400">Remember me</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-terracotta-500 hover:text-terracotta-600 hover:underline" href="{{ route('password.request') }}">
                    Forgot password?
                </a>
            @endif
        </div>

        <button type="submit"
                class="w-full px-6 py-3 bg-terracotta-500 hover:bg-terracotta-600 text-white font-semibold rounded-full shadow-warm transition">
            Log in
        </button>
    </form>

    <p class="text-center text-sm text-clay-400 mt-6">
        Don't have an account?
        <a href="{{ route('register') }}" class="text-terracotta-500 font-semibold hover:underline">Sign up</a>
    </p>
</x-guest-layout>
