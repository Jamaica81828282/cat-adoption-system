@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-pink-100 via-purple-100 to-blue-100 py-12 px-4">
    <div class="max-w-4xl mx-auto">
        
        <!-- Back Button -->
        <a href="{{ route('applications.index') }}" 
           class="inline-flex items-center text-pink-600 hover:text-pink-700 mb-6 font-semibold">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Back to My Applications
        </a>

        <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
            
            <!-- Header with Status -->
            <div class="bg-gradient-to-r from-green-500 to-green-600 text-white p-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold mb-2">Application Approved! 🎉</h1>
                        <p class="text-green-100">Your adoption application for {{ $application->cat->name }} has been approved</p>
                    </div>
                    <div class="bg-white text-green-600 px-4 py-2 rounded-full font-bold">
                        ✓ Approved
                    </div>
                </div>
            </div>

            <!-- Cat & Application Info -->
            <div class="p-8">
                <div class="grid md:grid-cols-2 gap-8 mb-8">
                    
                    <!-- Cat Image & Info -->
                    <div>
                        @php
                            $imagePath = ltrim($application->cat->image ?? '', '/');
                        @endphp
                        <img src="{{ Str::startsWith($imagePath, 'cats/') 
                                ? asset('storage/' . $imagePath)
                                : $application->cat->image }}" 
                             alt="{{ $application->cat->name }}" 
                             class="w-full rounded-xl shadow-lg mb-4">
                        
                        <div class="bg-pink-50 rounded-lg p-4">
                            <h3 class="text-2xl font-bold text-pink-600 mb-2">{{ $application->cat->name }}</h3>
                            <p class="text-gray-700"><strong>Breed:</strong> {{ $application->cat->breed }}</p>
                            <p class="text-gray-700"><strong>Age:</strong> {{ $application->cat->age }}</p>
                        </div>
                    </div>

                    <!-- Application Details -->
                    <div class="space-y-6">
                        <div>
                            <h3 class="text-xl font-bold text-gray-800 mb-4">Application Details</h3>
                            
                            <div class="space-y-3 bg-gray-50 rounded-lg p-4">
                                <div>
                                    <p class="text-sm text-gray-500">Application Date</p>
                                    <p class="font-semibold text-gray-800">{{ $application->created_at->format('F d, Y') }}</p>
                                </div>
                                
                                <div>
                                    <p class="text-sm text-gray-500">Application Fee Paid</p>
                                    <p class="font-semibold text-gray-800">₱{{ number_format($application->fee, 2) }}</p>
                                </div>
                                
                                <div>
                                    <p class="text-sm text-gray-500">Payment Method</p>
                                    <p class="font-semibold text-gray-800">{{ ucwords(str_replace('_', ' ', $application->payment_method)) }}</p>
                                </div>
                                
                                @if($application->payment_reference)
                                <div>
                                    <p class="text-sm text-gray-500">Payment Reference</p>
                                    <p class="font-semibold text-gray-800">{{ $application->payment_reference }}</p>
                                </div>
                                @endif

                                @if($application->notes)
                                <div>
                                    <p class="text-sm text-gray-500">Your Notes</p>
                                    <p class="text-gray-700">{{ $application->notes }}</p>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Next Steps -->
                <div class="bg-gradient-to-r from-blue-50 to-purple-50 border-2 border-blue-200 rounded-xl p-6 mb-6">
                    <h3 class="text-xl font-bold text-blue-900 mb-4 flex items-center">
                        <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                        </svg>
                        Next Steps for Adoption
                    </h3>
                    
                    <div class="space-y-4">
                        <div class="flex items-start">
                            <div class="bg-blue-500 text-white rounded-full w-8 h-8 flex items-center justify-center font-bold mr-4 flex-shrink-0">1</div>
                            <div>
                                <h4 class="font-semibold text-gray-800">Complete Adoption Payment</h4>
                                <p class="text-gray-600 text-sm">The full adoption fee is required before you can take your cat home.</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="bg-blue-500 text-white rounded-full w-8 h-8 flex items-center justify-center font-bold mr-4 flex-shrink-0">2</div>
                            <div>
                                <h4 class="font-semibold text-gray-800">Schedule a Visit</h4>
                                <p class="text-gray-600 text-sm">Contact us to arrange a visit and meet {{ $application->cat->name }}.</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="bg-blue-500 text-white rounded-full w-8 h-8 flex items-center justify-center font-bold mr-4 flex-shrink-0">3</div>
                            <div>
                                <h4 class="font-semibold text-gray-800">Prepare Your Home</h4>
                                <p class="text-gray-600 text-sm">Get food, litter box, toys, and other essentials ready.</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start">
                            <div class="bg-blue-500 text-white rounded-full w-8 h-8 flex items-center justify-center font-bold mr-4 flex-shrink-0">4</div>
                            <div>
                                <h4 class="font-semibold text-gray-800">Take Your Cat Home! 🏠</h4>
                                <p class="text-gray-600 text-sm">Once everything is ready, you can bring {{ $application->cat->name }} to your home!</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Information -->
                <div class="bg-pink-50 border border-pink-200 rounded-xl p-6">
                    <h3 class="text-lg font-bold text-pink-800 mb-3">📞 Contact Us</h3>
                    <div class="space-y-2 text-gray-700">
                        <p><strong>Location:</strong> 123 Cat Street, Cebu City</p>
                        <p><strong>Phone:</strong> 0917-123-4567</p>
                        <p><strong>Email:</strong> adopt@catcenter.com</p>
                        <p><strong>Office Hours:</strong> Monday - Friday, 9:00 AM - 5:00 PM</p>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-4 mt-8">
                    <a href="{{ route('applications.index') }}" 
                       class="flex-1 bg-gray-200 text-gray-700 text-center px-6 py-3 rounded-full hover:bg-gray-300 transition font-semibold">
                        Back to Applications
                    </a>
                    <a href="{{ route('adopt.index') }}" 
                       class="flex-1 bg-pink-500 text-white text-center px-6 py-3 rounded-full hover:bg-pink-600 transition font-semibold">
                        Browse More Cats
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection