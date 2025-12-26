@extends('layouts.app')

@section('content')
<div class="relative min-h-screen bg-gradient-to-br from-pink-200 via-purple-200 to-blue-200 py-12 overflow-hidden">

    <!-- Floating Paw Prints Animation -->
    <div class="absolute top-0 left-0 w-full h-full pointer-events-none">
        <span class="paw absolute w-12 h-12 bg-pink-300 rounded-full opacity-70 animate-paw1"></span>
        <span class="paw absolute w-10 h-10 bg-purple-300 rounded-full opacity-60 animate-paw2"></span>
        <span class="paw absolute w-14 h-14 bg-blue-300 rounded-full opacity-50 animate-paw3"></span>
    </div>

    <div class="relative max-w-6xl mx-auto px-6 z-10">
        <h1 class="text-4xl font-bold text-center text-pink-600 mb-12">Meet the Team 🌟</h1>

        <p class="text-center text-gray-700 mb-12">
            Our team is passionate about helping cats find loving homes. Get to know the people behind this adoption platform!
        </p>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
            <!-- Team Member Card -->
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden transition hover:scale-105 hover:shadow-2xl">
                <img src="{{ asset('images/member1.jpg') }}" alt="Jamaica" class="w-full h-64 object-cover">
                <div class="p-6 text-center">
                    <h2 class="text-xl font-semibold text-gray-800 mb-1">Jamaica Jumuad</h2>
                    <p class="text-pink-500 font-medium mb-2">Lead Developer</p>
                    <p class="text-gray-600 text-sm mb-4">Passionate about creating friendly and modern interfaces for all users.</p>
                    <div class="flex justify-center space-x-3">
                        <a href="#" class="text-blue-500 hover:text-blue-700"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-blue-400 hover:text-blue-600"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-pink-500 hover:text-pink-700"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-lg overflow-hidden transition hover:scale-105 hover:shadow-2xl">
                <img src="{{ asset('images/member2.jpg') }}" alt="Sabel" class="w-full h-64 object-cover">
                <div class="p-6 text-center">
                    <h2 class="text-xl font-semibold text-gray-800 mb-1">Kris Ann Dungog</h2>
                    <p class="text-purple-500 font-medium mb-2">Designer</p>
                    <p class="text-gray-600 text-sm mb-4">Ensures smooth operations and secure data handling for all applications.</p>
                    <div class="flex justify-center space-x-3">
                        <a href="#" class="text-blue-500 hover:text-blue-700"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-blue-400 hover:text-blue-600"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-pink-500 hover:text-pink-700"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-lg overflow-hidden transition hover:scale-105 hover:shadow-2xl">
                <img src="{{ asset('images/member3.jpg') }}" alt="Matt" class="w-full h-64 object-cover">
                <div class="p-6 text-center">
                    <h2 class="text-xl font-semibold text-gray-800 mb-1">Ingrid Maria Sofia Gacayan</h2>
                    <p class="text-yellow-500 font-medium mb-2">Designer</p>
                    <p class="text-gray-600 text-sm mb-4">Coordinates the team to ensure timely delivery and smooth workflow.</p>
                    <div class="flex justify-center space-x-3">
                        <a href="#" class="text-blue-500 hover:text-blue-700"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="text-blue-400 hover:text-blue-600"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-pink-500 hover:text-pink-700"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-12 text-center">
            <p class="text-gray-700 text-lg mb-4">We ❤️ cats and want to make adoption a joyful experience for everyone!</p>
            <a href="{{ route('adopt.index') }}" 
               class="bg-pink-500 text-white px-6 py-3 rounded-full hover:bg-pink-600 transition">
               Start Adopting Today 🐱
            </a>
        </div>
    </div>
</div>

<!-- Paw Print Animation CSS -->
<style>
@keyframes pawMove1 {
    0% { transform: translateX(-10%) translateY(0) rotate(0deg); opacity: 0.5; }
    50% { transform: translateX(110%) translateY(100vh) rotate(360deg); opacity: 0.2; }
    100% { transform: translateX(200%) translateY(-100vh) rotate(720deg); opacity: 0; }
}
@keyframes pawMove2 {
    0% { transform: translateX(0) translateY(0) rotate(0deg); opacity: 0.4; }
    50% { transform: translateX(100%) translateY(80vh) rotate(360deg); opacity: 0.1; }
    100% { transform: translateX(200%) translateY(-80vh) rotate(720deg); opacity: 0; }
}
@keyframes pawMove3 {
    0% { transform: translateX(-20%) translateY(0) rotate(0deg); opacity: 0.6; }
    50% { transform: translateX(120%) translateY(120vh) rotate(360deg); opacity: 0.2; }
    100% { transform: translateX(220%) translateY(-120vh) rotate(720deg); opacity: 0; }
}
.animate-paw1 { animation: pawMove1 20s linear infinite; top: 0; left: -10%; }
.animate-paw2 { animation: pawMove2 25s linear infinite; top: -5%; left: 0%; }
.animate-paw3 { animation: pawMove3 30s linear infinite; top: -10%; left: -20%; }
.paw { border-radius: 50%; position: absolute; z-index: 0; }
</style>
@endsection
