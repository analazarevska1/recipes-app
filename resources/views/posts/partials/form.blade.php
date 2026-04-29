{{-- Title --}}
<div>
    <label for="title" class="block text-sm font-semibold text-clay-500 mb-1.5">Recipe title <span class="text-terracotta-500">*</span></label>
    <input type="text" name="title" id="title" required maxlength="255"
           value="{{ old('title', $post->title ?? '') }}"
           placeholder="Grandma's apple pie"
           class="w-full px-4 py-2.5 bg-cream-50 border border-cream-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-terracotta-300 focus:border-transparent">
</div>

{{-- Description --}}
<div>
    <label for="description" class="block text-sm font-semibold text-clay-500 mb-1.5">Short description</label>
    <textarea name="description" id="description" rows="2" maxlength="1000"
              placeholder="A few words about this recipe..."
              class="w-full px-4 py-2.5 bg-cream-50 border border-cream-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-terracotta-300 focus:border-transparent resize-none">{{ old('description', $post->description ?? '') }}</textarea>
</div>

{{-- Image upload --}}
<div>
    <label for="image" class="block text-sm font-semibold text-clay-500 mb-1.5">Photo</label>
    <input type="file" name="image" id="image" accept="image/*" onchange="previewImage(event)"
           class="block w-full text-sm text-clay-400
                  file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0
                  file:text-sm file:font-semibold
                  file:bg-terracotta-100 file:text-terracotta-700
                  hover:file:bg-terracotta-200 cursor-pointer">

    <div class="mt-3">
        @if(isset($post) && $post && $post->image)
            <img id="imagePreview"
                 src="{{ Str::startsWith($post->image, 'http') ? $post->image : asset('storage/' . $post->image) }}"
                 class="w-full max-h-64 object-cover rounded-xl shadow-warm">
        @else
            <img id="imagePreview" class="hidden w-full max-h-64 object-cover rounded-xl shadow-warm">
        @endif
    </div>
</div>

{{-- Ingredients --}}
<div>
    <label for="ingredients" class="block text-sm font-semibold text-clay-500 mb-1.5">
        Ingredients <span class="text-terracotta-500">*</span>
        <span class="text-xs text-clay-300 font-normal">(separate with commas)</span>
    </label>
    <textarea name="ingredients" id="ingredients" rows="4" required
              placeholder="2 cups flour, 1 tsp salt, 3 eggs, ..."
              class="w-full px-4 py-2.5 bg-cream-50 border border-cream-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-terracotta-300 focus:border-transparent resize-none">{{ old('ingredients', $post->ingredients ?? '') }}</textarea>
</div>

{{-- Instructions --}}
<div>
    <label for="instructions" class="block text-sm font-semibold text-clay-500 mb-1.5">
        Instructions <span class="text-terracotta-500">*</span>
        <span class="text-xs text-clay-300 font-normal">(one step per line)</span>
    </label>
    <textarea name="instructions" id="instructions" rows="6" required
              placeholder="Preheat oven to 180°C.&#10;Mix dry ingredients.&#10;Add eggs and stir gently."
              class="w-full px-4 py-2.5 bg-cream-50 border border-cream-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-terracotta-300 focus:border-transparent resize-none">{{ old('instructions', $post->instructions ?? '') }}</textarea>
</div>

{{-- Prep / Cook / Servings / Difficulty --}}
<div class="grid grid-cols-2 md:grid-cols-4 gap-4">
    <div>
        <label for="prep_time" class="block text-sm font-semibold text-clay-500 mb-1.5">Prep (min)</label>
        <input type="number" min="0" max="1440" name="prep_time" id="prep_time"
               value="{{ old('prep_time', $post->prep_time ?? '') }}"
               class="w-full px-3 py-2.5 bg-cream-50 border border-cream-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-terracotta-300 focus:border-transparent">
    </div>
    <div>
        <label for="cook_time" class="block text-sm font-semibold text-clay-500 mb-1.5">Cook (min)</label>
        <input type="number" min="0" max="1440" name="cook_time" id="cook_time"
               value="{{ old('cook_time', $post->cook_time ?? '') }}"
               class="w-full px-3 py-2.5 bg-cream-50 border border-cream-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-terracotta-300 focus:border-transparent">
    </div>
    <div>
        <label for="servings" class="block text-sm font-semibold text-clay-500 mb-1.5">Servings</label>
        <input type="number" min="1" max="100" name="servings" id="servings"
               value="{{ old('servings', $post->servings ?? '') }}"
               class="w-full px-3 py-2.5 bg-cream-50 border border-cream-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-terracotta-300 focus:border-transparent">
    </div>
    <div>
        <label for="difficulty" class="block text-sm font-semibold text-clay-500 mb-1.5">Difficulty</label>
        <select name="difficulty" id="difficulty"
                class="w-full px-3 py-2.5 bg-cream-50 border border-cream-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-terracotta-300 focus:border-transparent">
            <option value="">—</option>
            @foreach(['Easy','Medium','Hard'] as $level)
                <option value="{{ $level }}" {{ old('difficulty', $post->difficulty ?? '') === $level ? 'selected' : '' }}>{{ $level }}</option>
            @endforeach
        </select>
    </div>
</div>

{{-- Tags --}}
<div>
    <label class="block text-sm font-semibold text-clay-500 mb-2">Tags</label>
    <div class="flex flex-wrap gap-2">
        @php
            $selectedTags = isset($post) && $post ? $post->tags->pluck('id')->toArray() : (old('tags', []));
        @endphp
        @foreach($tags as $tag)
            <label class="cursor-pointer">
                <input type="checkbox" name="tags[]" value="{{ $tag->id }}"
                       {{ in_array($tag->id, $selectedTags) ? 'checked' : '' }}
                       class="peer sr-only">
                <span class="px-3 py-1.5 rounded-full border border-cream-200 text-sm text-clay-400
                             peer-checked:bg-terracotta-500 peer-checked:text-white peer-checked:border-terracotta-500
                             hover:border-terracotta-300 transition inline-block">
                    {{ $tag->name }}
                </span>
            </label>
        @endforeach
    </div>
</div>
