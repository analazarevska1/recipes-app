@extends('layouts.main')
@section('title', 'Share a recipe')

@section('content')
<div class="max-w-3xl mx-auto px-6 py-10">
    <div class="text-center mb-8">
        <span class="text-4xl">🍴</span>
        <h1 class="font-serif text-4xl font-bold text-clay-500 mt-3">Share your recipe</h1>
        <p class="text-clay-300 mt-2">Tell us what you’ve been cooking — the community would love to try it.</p>
    </div>

    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data"
          class="bg-white rounded-3xl shadow-warm border border-cream-100 p-8 space-y-6">
        @csrf
        @include('posts.partials.form', ['post' => null])

        <div class="pt-4 border-t border-cream-100">
            <button type="submit"
                    class="w-full px-6 py-3 bg-terracotta-500 hover:bg-terracotta-600 text-white text-lg font-semibold rounded-full shadow-warm-lg transition">
                Save recipe
            </button>
        </div>
    </form>
</div>

<script>
    function previewImage(event) {
        const preview = document.getElementById('imagePreview');
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = (e) => {
                preview.src = e.target.result;
                preview.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        }
    }
</script>
@endsection
