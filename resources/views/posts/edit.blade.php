@extends('layouts.main')
@section('title', 'Edit ' . $post->title)

@section('content')
<div class="max-w-3xl mx-auto px-6 py-10">
    <div class="text-center mb-8">
        <span class="text-4xl">✏️</span>
        <h1 class="font-serif text-4xl font-bold text-clay-500 mt-3">Edit recipe</h1>
        <p class="text-clay-300 mt-2">Make any updates to your recipe below.</p>
    </div>

    <form action="{{ route('posts.update', $post) }}" method="POST" enctype="multipart/form-data"
          class="bg-white rounded-3xl shadow-warm border border-cream-100 p-8 space-y-6">
        @csrf
        @method('PUT')
        @include('posts.partials.form', ['post' => $post])

        <div class="pt-4 border-t border-cream-100 flex flex-col sm:flex-row gap-3">
            <button type="submit"
                    class="flex-1 px-6 py-3 bg-terracotta-500 hover:bg-terracotta-600 text-white text-lg font-semibold rounded-full shadow-warm-lg transition">
                Update recipe
            </button>
            <a href="{{ route('posts.show', $post) }}"
               class="flex-1 text-center px-6 py-3 bg-cream-100 hover:bg-cream-200 text-clay-500 text-lg font-semibold rounded-full transition">
                Cancel
            </a>
        </div>
    </form>

    <form action="{{ route('posts.destroy', $post) }}" method="POST"
          onsubmit="return confirm('Delete this recipe permanently? This cannot be undone.')"
          class="mt-8 text-center">
        @csrf @method('DELETE')
        <button class="text-sm text-red-500 hover:text-red-700 hover:underline transition">
            Delete this recipe
        </button>
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
