@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-pink-100 via-purple-100 to-blue-100 py-12 flex justify-center items-start">
    <div class="max-w-5xl w-full bg-white shadow-lg rounded-2xl overflow-hidden flex flex-col md:flex-row">
        <!-- Left: Cat Image -->
        <div class="md:w-1/2 bg-gray-100 flex justify-center items-center p-6">
            @php
                $imagePath = ltrim($cat->image ?? '', '/');
            @endphp
            <img src="{{ Str::startsWith($imagePath, 'cats/') 
                    ? asset('storage/' . $imagePath)
                    : $cat->image }}" 
                alt="{{ $cat->name }}" 
                class="rounded-xl w-full max-w-sm object-cover shadow-md">
        </div>

        <!-- Right: Cat Info -->
        <div class="md:w-1/2 p-8 flex flex-col justify-center">
            <h2 class="text-3xl font-bold text-pink-600 mb-4">{{ $cat->name }}</h2>

            <ul class="text-gray-700 space-y-2 mb-6">
                <li><strong>Breed:</strong> {{ $cat->breed }}</li>
                <li><strong>Age:</strong> {{ $cat->age }} years</li>
            </ul>

            <p class="text-gray-600 mb-6">{{ $cat->description }}</p>

            <div class="flex space-x-4">
                <a href="{{ route('applications.create', $cat->id) }}" 
                   class="bg-pink-500 text-white px-6 py-2 rounded-full hover:bg-pink-600 transition">
                   Apply for Adoption 💕
                </a>

                <a href="{{ route('adopt.index') }}" 
                   class="bg-gray-200 text-gray-700 px-6 py-2 rounded-full hover:bg-gray-300 transition">
                    Back
                </a>
            </div>
        </div>
    </div>
</div>
@endsection