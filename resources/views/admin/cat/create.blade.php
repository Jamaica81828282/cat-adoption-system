@extends('layouts.admin')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12" style="background: linear-gradient(to bottom right, #ffe4e6, #fff0f5);">
    <div class="w-full max-w-2xl bg-white p-8 rounded-2xl shadow-lg border border-gray-200">
        <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">🐾 Add a New Furry Friend</h1>

        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.cats.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            
            <!-- Cat Name -->
            <div>
                <label class="block font-semibold text-gray-700 mb-2">Cat Name 🐱</label>
                <input 
                    type="text" 
                    name="name" 
                    value="{{ old('name') }}"
                    class="w-full border-2 border-gray-300 p-3 rounded-xl focus:ring-2 focus:ring-pink-300 focus:border-pink-400 focus:outline-none transition-all" 
                    placeholder="e.g., Whiskers, Luna, Mittens" 
                    required>
            </div>

            <!-- Age, Breed, Gender Row -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Age -->
                <div>
                    <label class="block font-semibold text-gray-700 mb-2">Age (years) 🎂</label>
                    <input 
                        type="number" 
                        name="age" 
                        value="{{ old('age') }}"
                        step="0.1"
                        min="0"
                        class="w-full border-2 border-gray-300 p-3 rounded-xl focus:ring-2 focus:ring-pink-300 focus:border-pink-400 focus:outline-none transition-all" 
                        placeholder="e.g., 2"
                        required>
                </div>

                <!-- Gender -->
                <div>
                    <label class="block font-semibold text-gray-700 mb-2">Gender 💝</label>
                    <select 
                        name="gender" 
                        class="w-full border-2 border-gray-300 p-3 rounded-xl focus:ring-2 focus:ring-pink-300 focus:border-pink-400 focus:outline-none transition-all cursor-pointer" 
                        required>
                        <option value="">Select...</option>
                        <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>♂️ Male</option>
                        <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>♀️ Female</option>
                    </select>
                </div>

                <!-- Breed -->
                <div>
                    <label class="block font-semibold text-gray-700 mb-2">Breed 🐾</label>
                    <input 
                        type="text" 
                        name="breed" 
                        value="{{ old('breed') }}"
                        class="w-full border-2 border-gray-300 p-3 rounded-xl focus:ring-2 focus:ring-pink-300 focus:border-pink-400 focus:outline-none transition-all" 
                        placeholder="e.g., Persian"
                        required>
                </div>
            </div>

            <!-- Description -->
            <div>
                <label class="block font-semibold text-gray-700 mb-2">Description 📝</label>
                <textarea 
                    name="description" 
                    rows="4"
                    class="w-full border-2 border-gray-300 p-3 rounded-xl focus:ring-2 focus:ring-pink-300 focus:border-pink-400 focus:outline-none transition-all resize-none" 
                    placeholder="Tell us about this adorable cat's personality, habits, and what makes them special...">{{ old('description') }}</textarea>
            </div>

            <!-- Image Upload with Preview -->
            <div>
                <label class="block font-semibold text-gray-700 mb-2">Upload Photo 🖼️</label>
                <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:border-pink-400 transition-all">
                    <input 
                        type="file" 
                        name="image" 
                        id="imageInput"
                        class="hidden" 
                        accept="image/*"
                        required>
                    
                    <label for="imageInput" class="cursor-pointer">
                        <div id="imagePreviewContainer" class="hidden mb-4">
                            <img id="imagePreview" src="" alt="Preview" class="max-w-full h-64 object-cover mx-auto rounded-lg shadow-md">
                        </div>
                        
                        <div id="uploadPrompt">
                            <svg class="mx-auto h-12 w-12 text-gray-400 mb-3" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                                <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <p class="text-gray-600 font-medium mb-1">Click to upload an image</p>
                            <p class="text-sm text-gray-500">PNG, JPG, GIF up to 2MB</p>
                        </div>
                    </label>
                    
                    <button 
                        type="button" 
                        id="changeImageBtn" 
                        class="hidden mt-3 text-pink-500 hover:text-pink-600 font-medium">
                        Change Image
                    </button>
                </div>
            </div>

            <!-- Availability Checkbox -->
            <div class="flex items-center">
                <input 
                    type="checkbox" 
                    name="available" 
                    id="available" 
                    value="1" 
                    checked
                    class="w-5 h-5 text-pink-500 border-gray-300 rounded focus:ring-pink-400 cursor-pointer">
                <label for="available" class="ml-2 text-gray-700 font-medium cursor-pointer">
                    Available for adoption
                </label>
            </div>

            <!-- Submit Button -->
            <div class="flex gap-3 pt-4">
                <button 
                    type="submit" 
                    class="flex-1 bg-gradient-to-r from-pink-500 to-purple-500 text-white font-semibold px-6 py-3 rounded-xl hover:from-pink-600 hover:to-purple-600 transform hover:scale-105 transition-all shadow-lg">
                    🎉 Add Cat
                </button>
                
                <a 
                    href="{{ route('admin.cats.index') }}" 
                    class="px-6 py-3 bg-gray-200 text-gray-700 font-semibold rounded-xl hover:bg-gray-300 transition-all">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

<script>
    const imageInput = document.getElementById('imageInput');
    const imagePreview = document.getElementById('imagePreview');
    const imagePreviewContainer = document.getElementById('imagePreviewContainer');
    const uploadPrompt = document.getElementById('uploadPrompt');
    const changeImageBtn = document.getElementById('changeImageBtn');

    imageInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            // Check file size (2MB = 2097152 bytes)
            if (file.size > 2097152) {
                alert('File size must be less than 2MB');
                imageInput.value = '';
                return;
            }

            // Check file type
            if (!file.type.startsWith('image/')) {
                alert('Please upload an image file');
                imageInput.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                imagePreviewContainer.classList.remove('hidden');
                uploadPrompt.classList.add('hidden');
                changeImageBtn.classList.remove('hidden');
            }
            reader.readAsDataURL(file);
        }
    });

    changeImageBtn.addEventListener('click', function() {
        imageInput.click();
    });
</script>
@endsection