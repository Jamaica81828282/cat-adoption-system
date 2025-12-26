@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-pink-100 via-purple-100 to-blue-100 py-12">
    <div class="max-w-4xl mx-auto px-6">
        <!-- Header -->
        <div class="text-center mb-8">
            <h1 class="text-5xl font-extrabold text-gray-800 mb-3">✏️ Edit Cat</h1>
            <p class="text-gray-600 text-lg">Update {{ $cat->name }}'s information</p>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-3xl shadow-2xl p-8 border-4 border-pink-200">
            <form action="{{ route('admin.cats.update', $cat->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid md:grid-cols-2 gap-6 mb-6">
                    <!-- Cat Name -->
                    <div>
                        <label class="block text-gray-700 font-bold mb-2 text-lg">
                            🐱 Cat Name
                        </label>
                        <input type="text" name="name" value="{{ old('name', $cat->name) }}"
                               class="w-full px-4 py-3 border-2 border-pink-300 rounded-2xl focus:ring-4 focus:ring-pink-200 focus:border-pink-500 focus:outline-none transition"
                               placeholder="Enter cat's name"
                               required>
                        @error('name')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Breed -->
                    <div>
                        <label class="block text-gray-700 font-bold mb-2 text-lg">
                            🎀 Breed
                        </label>
                        <input type="text" name="breed" value="{{ old('breed', $cat->breed) }}"
                               class="w-full px-4 py-3 border-2 border-purple-300 rounded-2xl focus:ring-4 focus:ring-purple-200 focus:border-purple-500 focus:outline-none transition"
                               placeholder="Enter cat's breed"
                               required>
                        @error('breed')
                            <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Age -->
                <div class="mb-6">
                    <label class="block text-gray-700 font-bold mb-2 text-lg">
                        🎂 Age
                    </label>
                    <input type="number" name="age" value="{{ old('age', $cat->age) }}" min="0"
                           class="w-full px-4 py-3 border-2 border-blue-300 rounded-2xl focus:ring-4 focus:ring-blue-200 focus:border-blue-500 focus:outline-none transition"
                           placeholder="Enter cat's age"
                           required>
                    @error('age')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="mb-6">
                    <label class="block text-gray-700 font-bold mb-2 text-lg">
                        📝 Description
                    </label>
                    <textarea name="description" rows="4"
                              class="w-full px-4 py-3 border-2 border-pink-300 rounded-2xl focus:ring-4 focus:ring-pink-200 focus:border-pink-500 focus:outline-none transition resize-none"
                              placeholder="Tell us about this adorable cat...">{{ old('description', $cat->description) }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Cat Image -->
                <div class="mb-8">
                    <label class="block text-gray-700 font-bold mb-3 text-lg">
                        📸 Cat Image
                    </label>
                    
                    <!-- Current Image Preview -->
                    @if($cat->image)
                        <div class="mb-4">
                            <p class="text-sm text-gray-600 mb-2">Current Image:</p>
                            <div class="relative inline-block">
                                <img src="{{ asset('storage/' . $cat->image) }}" 
                                     alt="{{ $cat->name }}" 
                                     class="w-48 h-48 object-cover rounded-3xl shadow-lg border-4 border-pink-200">
                                <div class="absolute -top-2 -right-2 bg-pink-500 text-white rounded-full p-2 shadow-lg">
                                    ❤️
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- File Upload -->
                    <div class="relative">
                        <input type="file" name="image" accept="image/*" id="imageUpload"
                               class="hidden">
                        <label for="imageUpload" 
                               class="flex items-center justify-center w-full px-6 py-4 border-2 border-dashed border-purple-300 rounded-2xl cursor-pointer hover:border-purple-500 hover:bg-purple-50 transition">
                            <div class="text-center">
                                <svg class="mx-auto h-12 w-12 text-purple-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                    <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                                <p class="mt-2 text-sm text-gray-600">
                                    <span class="font-semibold text-purple-600">Click to upload</span> or drag and drop
                                </p>
                                <p class="text-xs text-gray-500 mt-1">PNG, JPG, GIF up to 2MB</p>
                            </div>
                        </label>
                    </div>
                    <p class="text-gray-500 text-sm mt-2 italic">💡 Leave empty to keep current image</p>
                    @error('image')
                        <p class="text-red-500 text-sm mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4">
                    <button type="submit"
                            class="flex-1 bg-pink-500 text-white px-8 py-4 rounded-2xl font-bold text-lg hover:bg-pink-600 transition transform hover:scale-105 hover:-translate-y-1 shadow-xl flex items-center justify-center gap-2">
                        <span class="text-2xl">💾</span>
                        Update Cat
                    </button>
                    <a href="{{ route('admin.cats.index') }}"
                       class="flex-1 bg-gray-500 text-white px-8 py-4 rounded-2xl font-bold text-lg hover:bg-gray-600 transition transform hover:scale-105 hover:-translate-y-1 shadow-xl flex items-center justify-center gap-2">
                        <span class="text-2xl">←</span>
                        Cancel
                    </a>
                </div>
            </form>
        </div>

        <!-- Fun decorative elements -->
        <div class="mt-8 text-center">
            <p class="text-gray-500 text-sm">🐾 Made with love for our furry friends 🐾</p>
        </div>
    </div>
</div>

<!-- Preview selected image -->
<script>
document.getElementById('imageUpload').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            // You can add image preview functionality here if desired
            console.log('New image selected:', file.name);
        }
        reader.readAsDataURL(file);
    }
});
</script>
@endsection