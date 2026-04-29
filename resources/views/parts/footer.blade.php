<footer class="mt-20 bg-clay-500 text-cream-100">
    <div class="max-w-7xl mx-auto px-6 py-12 grid grid-cols-1 md:grid-cols-3 gap-8">

        <div>
            <div class="flex items-center gap-2 mb-3">
                <span class="text-2xl">🍅</span>
                <span class="font-serif text-2xl font-bold text-cream-50">TastyShare</span>
            </div>
            <p class="text-sm text-cream-200 leading-relaxed">
                Discover, save, and share delicious recipes from a community of home cooks.
            </p>
        </div>

        <div>
            <h3 class="font-semibold mb-3 text-cream-50">Explore</h3>
            <ul class="space-y-2 text-sm text-cream-200">
                <li><a href="{{ route('posts.index') }}" class="hover:text-terracotta-200 transition">All recipes</a></li>
                <li><a href="{{ route('posts.index', ['tag' => 'Breakfast']) }}" class="hover:text-terracotta-200 transition">Breakfast</a></li>
                <li><a href="{{ route('posts.index', ['tag' => 'Dinner']) }}" class="hover:text-terracotta-200 transition">Dinner</a></li>
                <li><a href="{{ route('posts.index', ['tag' => 'Dessert']) }}" class="hover:text-terracotta-200 transition">Desserts</a></li>
            </ul>
        </div>

        <div>
            <h3 class="font-semibold mb-3 text-cream-50">Stay Connected</h3>
            <p class="text-sm text-cream-200 mb-3">Follow us for tasty updates!</p>
            <div class="flex gap-4 text-sm">
                <a href="#" class="hover:text-terracotta-200 transition">Instagram</a>
                <a href="#" class="hover:text-terracotta-200 transition">Facebook</a>
                <a href="#" class="hover:text-terracotta-200 transition">Twitter</a>
            </div>
        </div>
    </div>

    <div class="border-t border-clay-400/40 py-4 text-center text-xs text-cream-200">
        © {{ date('Y') }} TastyShare. Made with love and butter.
    </div>
</footer>
