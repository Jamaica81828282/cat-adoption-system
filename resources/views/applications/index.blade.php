@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-pink-50 via-purple-50 to-blue-50 py-12 px-4">
    <div class="max-w-6xl mx-auto">
        
        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-4xl font-bold text-gray-800 flex items-center">
                📋 My Adoption Applications
            </h1>
            <a href="{{ route('adopt.index') }}" 
               class="bg-pink-500 text-white px-6 py-2 rounded-full hover:bg-pink-600 transition shadow-md">
                Browse More Cats
            </a>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-800 px-6 py-4 rounded-lg mb-6 flex items-center">
                <svg class="w-6 h-6 mr-3" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        <!-- Applications Grid -->
        @if($applications->isEmpty())
            <div class="bg-white rounded-2xl shadow-lg p-12 text-center">
                <div class="text-6xl mb-4">😿</div>
                <h2 class="text-2xl font-semibold text-gray-700 mb-2">No Applications Yet</h2>
                <p class="text-gray-500 mb-6">You haven't applied to adopt any cats yet.</p>
                <a href="{{ route('adopt.index') }}" 
                   class="inline-block bg-pink-500 text-white px-8 py-3 rounded-full hover:bg-pink-600 transition shadow-md">
                    Find Your Perfect Cat 💕
                </a>
            </div>
        @else
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($applications as $application)
                    <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition transform hover:-translate-y-1">
                        <!-- Cat Image -->
                        <div class="relative h-48 bg-gray-200">
                            @php
                                $imagePath = ltrim($application->cat->image ?? '', '/');
                            @endphp
                            <img src="{{ Str::startsWith($imagePath, 'cats/') 
                                    ? asset('storage/' . $imagePath)
                                    : $application->cat->image }}" 
                                 alt="{{ $application->cat->name }}" 
                                 class="w-full h-full object-cover">
                            
                            <!-- Status Badge -->
                            <div class="absolute top-3 right-3">
                                @if($application->status === 'approved')
                                    <span class="bg-green-500 text-white px-3 py-1 rounded-full text-xs font-semibold shadow-lg">
                                        ✓ Approved
                                    </span>
                                @elseif($application->status === 'rejected')
                                    <span class="bg-red-500 text-white px-3 py-1 rounded-full text-xs font-semibold shadow-lg">
                                        ✗ Declined
                                    </span>
                                @else
                                    <span class="bg-yellow-500 text-white px-3 py-1 rounded-full text-xs font-semibold shadow-lg">
                                        ⏳ Pending
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Card Content -->
                        <div class="p-6">
                            <h3 class="text-2xl font-bold text-gray-800 mb-2">
                                {{ $application->cat->name }}
                            </h3>
                            
                            <div class="space-y-2 text-sm text-gray-600 mb-4">
                                <p><strong>Breed:</strong> {{ $application->cat->breed }}</p>
                                <p><strong>Applied:</strong> {{ $application->created_at->format('M d, Y') }}</p>
                                <p><strong>Payment Method:</strong> {{ ucwords(str_replace('_', ' ', $application->payment_method)) }}</p>
                                
                                @if($application->payment_reference)
                                    <p><strong>Reference:</strong> {{ $application->payment_reference }}</p>
                                @endif
                            </div>

                            <!-- Action Buttons -->
                            @if($application->status === 'approved')
                                <div class="bg-green-50 border border-green-200 rounded-lg p-4 mb-4">
                                    <p class="text-green-800 text-sm font-semibold mb-2">
                                        🎉 Congratulations! Your application was approved!
                                    </p>
                                    <p class="text-gray-600 text-xs">
                                        Please proceed with the adoption payment and arrangements.
                                    </p>
                                </div>
                                
                                <a href="{{ route('applications.show', $application->id) }}" 
                                   class="block w-full bg-gradient-to-r from-green-500 to-green-600 text-white text-center px-4 py-3 rounded-lg hover:from-green-600 hover:to-green-700 transition shadow-md font-semibold">
                                    📄 View Details & Proceed
                                </a>
                            @elseif($application->status === 'rejected')
                                <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                                    <p class="text-red-800 text-sm">
                                        Unfortunately, this application was not approved. You can apply for other cats.
                                    </p>
                                </div>
                            @else
                                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                                    <p class="text-yellow-800 text-sm">
                                        ⏳ Your application is being reviewed. Please wait for admin approval.
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection