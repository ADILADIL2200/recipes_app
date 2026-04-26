    <div class="max-w-3xl mx-auto py-10 px-4">

        <h1 class="text-2xl font-bold text-gray-900 mb-6">Create New Recipe</h1>

        <form action="{{ route('recipes.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Title --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Title</label>
                <input type="text" name="title" value="{{ old('title') }}"
                       class="mt-1 w-full border rounded px-3 py-2 @error('title') border-red-500 @enderror">
                @error('title') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Category --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Category</label>
                <select name="category_id"
                        class="mt-1 w-full border rounded px-3 py-2 @error('category_id') border-red-500 @enderror">
                    <option value="">-- Select Category --</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Tags --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Tags</label>
                <div class="flex flex-wrap gap-3">
                    @foreach ($tags as $tag)
                        <label class="flex items-center gap-1 text-sm text-gray-700">
                            <input type="checkbox" name="tags[]" value="{{ $tag->id }}"
                                {{ in_array($tag->id, old('tags', [])) ? 'checked' : '' }}>
                            {{ $tag->name }}
                        </label>
                    @endforeach
                </div>
                @error('tags') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Description --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Description</label>
                <textarea name="description" rows="3"
                          class="mt-1 w-full border rounded px-3 py-2">{{ old('description') }}</textarea>
            </div>

            {{-- Ingredients --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Ingredients</label>
                <textarea name="ingredients" rows="5"
                          class="mt-1 w-full border rounded px-3 py-2 @error('ingredients') border-red-500 @enderror"
                          placeholder="One ingredient per line...">{{ old('ingredients') }}</textarea>
                @error('ingredients') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Steps --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Instructions</label>
                <textarea name="steps" rows="6"
                          class="mt-1 w-full border rounded px-3 py-2 @error('steps') border-red-500 @enderror"
                          placeholder="Step by step instructions...">{{ old('steps') }}</textarea>
                @error('steps') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Prep / Cook Time / Servings --}}
            <div class="grid grid-cols-3 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Prep Time (min)</label>
                    <input type="number" name="prep_time" value="{{ old('prep_time') }}"
                           class="mt-1 w-full border rounded px-3 py-2" min="0">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Cook Time (min)</label>
                    <input type="number" name="cook_time" value="{{ old('cook_time') }}"
                           class="mt-1 w-full border rounded px-3 py-2" min="0">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Servings</label>
                    <input type="number" name="servings" value="{{ old('servings') }}"
                           class="mt-1 w-full border rounded px-3 py-2" min="1">
                </div>
            </div>

            {{-- Image --}}
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Image</label>
                <input type="file" name="image" accept="image/*"
                       class="mt-1 w-full @error('image') border-red-500 @enderror">
                @error('image') <p class="text-red-500 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            {{-- Published --}}
            <div class="mb-6 flex items-center gap-2">
                <input type="checkbox" name="is_published" value="1"
                       {{ old('is_published') ? 'checked' : '' }}>
                <label class="text-sm text-gray-700">Publish this recipe</label>
            </div>

            {{-- Submit --}}
            <div class="flex gap-3">
                <button type="submit"
                        class="px-6 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                    Save Recipe
                </button>
                <a href="{{ route('login') }}"
                   class="px-6 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300">
                    Cancel
                </a>
            </div>

        </form>
    </div>
