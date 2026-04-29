<x-guest-layout>
    <h1 class="font-serif text-3xl font-bold text-clay-500 mb-1 text-center">Join TastyShare</h1>
    <p class="text-clay-300 text-sm mb-6 text-center">Create an account to share recipes.</p>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <div>
            <label for="name" class="block text-sm font-semibold text-clay-500 mb-1.5">Name</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                   class="w-full px-4 py-2.5 bg-cream-50 border border-cream-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-terracotta-300 focus:border-transparent">
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <div>
            <label for="email" class="block text-sm font-semibold text-clay-500 mb-1.5">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                   class="w-full px-4 py-2.5 bg-cream-50 border border-cream-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-terracotta-300 focus:border-transparent">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <label for="password" class="block text-sm font-semibold text-clay-500 mb-1.5">Password</label>
            <input id="password" type="password" name="password" required autocomplete="new-password"
                   class="w-full px-4 py-2.5 bg-cream-50 border border-cream-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-terracotta-300 focus:border-transparent">
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-semibold text-clay-500 mb-1.5">Confirm password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                   class="w-full px-4 py-2.5 bg-cream-50 border border-cream-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-terracotta-300 focus:border-transparent">
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <button type="submit"
                class="w-full px-6 py-3 bg-terracotta-500 hover:bg-terracotta-600 text-white font-semibold rounded-full shadow-warm transition">
            Create account
        </button>
    </form>

    <p class="text-center text-sm text-clay-400 mt-6">
        Already have an account?
        <a href="{{ route('login') }}" class="text-terracotta-500 font-semibold hover:underline">Log in</a>
    </p>
</x-guest-layout>
