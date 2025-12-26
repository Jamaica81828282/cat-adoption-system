@extends('layouts.app')

@section('content')
 
<div class="min-h-screen bg-gradient-to-br from-pink-100 via-purple-100 to-blue-100 py-12">
    <div class="max-w-6xl mx-auto px-6">
        <h1 class="text-4xl font-bold text-gray-800 text-center mb-10">🐾 Meet Our Adorable Cats</h1>

        <!-- Cute Filter Section -->
        <div class="bg-white rounded-3xl shadow-lg p-6 mb-10">
            <form method="GET" action="{{ route('adopt.index') }}" class="space-y-4">
                <!-- Search Bar -->
                <div class="relative">
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}"
                        placeholder=" Search by name or breed..." 
                        class="w-full px-5 py-3 pl-12 rounded-full border-2 border-pink-200 focus:border-pink-400 focus:outline-none transition">
                    <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-2xl">🔍</span>
                </div>

                <!-- Filter Buttons -->
                <div class="flex flex-wrap gap-3 justify-center">
                    <!-- Age Filter -->
                    <select 
                        name="age" 
                        class="px-4 py-2 rounded-full border-2 border-purple-200 focus:border-purple-400 focus:outline-none bg-white hover:bg-purple-50 transition cursor-pointer">
                        <option value="">🎂 All Ages</option>
                        <option value="kitten" {{ request('age') == 'kitten' ? 'selected' : '' }}>Kitten (0-1 year)</option>
                        <option value="young" {{ request('age') == 'young' ? 'selected' : '' }}>Young (1-3 years)</option>
                        <option value="adult" {{ request('age') == 'adult' ? 'selected' : '' }}>Adult (3-7 years)</option>
                        <option value="senior" {{ request('age') == 'senior' ? 'selected' : '' }}>Senior (7+ years)</option>
                    </select>

                    <!-- Gender Filter -->
                    <select 
                        name="gender" 
                        class="px-4 py-2 rounded-full border-2 border-blue-200 focus:border-blue-400 focus:outline-none bg-white hover:bg-blue-50 transition cursor-pointer">
                        <option value="">💝 All Genders</option>
                        <option value="male" {{ request('gender') == 'male' ? 'selected' : '' }}>♂️ Male</option>
                        <option value="female" {{ request('gender') == 'female' ? 'selected' : '' }}>♀️ Female</option>
                    </select>

                    <!-- Breed Filter (if you have this field) -->
                    <select 
                        name="breed" 
                        class="px-4 py-2 rounded-full border-2 border-pink-200 focus:border-pink-400 focus:outline-none bg-white hover:bg-pink-50 transition cursor-pointer">
                        <option value="">🐱 All Breeds</option>
                        <option value="Persian" {{ request('breed') == 'Persian' ? 'selected' : '' }}>Persian</option>
                        <option value="Siamese" {{ request('breed') == 'Siamese' ? 'selected' : '' }}>Siamese</option>
                        <option value="Maine Coon" {{ request('breed') == 'Maine Coon' ? 'selected' : '' }}>Maine Coon</option>
                        <option value="British Shorthair" {{ request('breed') == 'British Shorthair' ? 'selected' : '' }}>British Shorthair</option>
                        <option value="Mixed" {{ request('breed') == 'Mixed' ? 'selected' : '' }}>Mixed Breed</option>
                        <option value="Other" {{ request('breed') == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>

                    <!-- Action Buttons -->
                    <button 
                        type="submit" 
                        class="px-6 py-2 bg-gradient-to-r from-pink-400 to-purple-400 text-white rounded-full hover:from-pink-500 hover:to-purple-500 transition shadow-md">
                        ✨ Apply Filters
                    </button>
                    
                    <a 
                        href="{{ route('adopt.index') }}" 
                        class="px-6 py-2 bg-gray-200 text-gray-700 rounded-full hover:bg-gray-300 transition">
                        🔄 Clear All
                    </a>
                </div>
            </form>
        </div>

        <!-- Results Count (Optional) -->
        @if(request()->hasAny(['search', 'age', 'gender', 'breed']))
            <div class="text-center mb-6">
                <p class="text-gray-600">
                    Found <span class="font-bold text-pink-600">{{ $cats->count() }}</span> adorable cats
                </p>
            </div>
        @endif

        <!-- Cat Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
            @forelse ($cats as $cat)
                <div class="bg-white rounded-2xl shadow-md overflow-hidden hover:shadow-xl transition-all duration-300 flex flex-col">
                    <!-- Cat Image -->
                    <div class="flex-shrink-0 h-56 overflow-hidden">
                        @php
                            $imagePath = ltrim($cat->image ?? '', '/');
                        @endphp
                        <img src="{{ Str::startsWith($imagePath, 'cats/') 
                                ? asset('storage/' . $imagePath)
                                : $cat->image }}" 
                             alt="{{ $cat->name }}" 
                             class="w-full h-full object-cover">
                    </div>

                    <!-- Cat Info -->
                    <div class="p-6 text-center flex flex-col justify-between flex-1">
                        <div>
                            <h2 class="text-2xl font-semibold text-gray-800 mb-2">{{ $cat->name }}</h2>
                            <p class="text-gray-500">{{ $cat->breed }} • {{ $cat->age }} {{ $cat->age_unit ?? '' }} • {{ $cat->gender === 'male' ? ' Male' : ' Female' }}</p>
                            <p class="mt-3 text-gray-600">{{ Str::limit($cat->description, 60) }}</p>
                        </div>

                        <a href="{{ route('cats.show', $cat->id) }}" 
                           class="inline-block mt-4 px-5 py-2 bg-pink-500 text-white rounded-full hover:bg-pink-600 transition">
                            View Details
                        </a>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <div class="text-6xl mb-4">😿</div>
                    <p class="text-xl text-gray-600">No cats found matching your filters</p>
                    <a href="{{ route('adopt.index') }}" class="inline-block mt-4 text-pink-500 hover:text-pink-600">
                        View all cats →
                    </a>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection