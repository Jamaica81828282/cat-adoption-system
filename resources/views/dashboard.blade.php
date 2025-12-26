@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-pink-200 via-purple-200 to-blue-200 py-12">
    <!-- Welcome Section -->
    <section class="text-center px-6">
        <h2 class="text-4xl font-extrabold text-gray-800">Welcome back, {{ Auth::user()->name }}! 🐱</h2>
        <p class="mt-4 text-gray-600 text-lg">
            Discover tips and fun facts about our adorable cats while exploring their cute faces!
        </p>
        <a href="{{ route('adopt.index') }}"
           class="mt-8 inline-block bg-pink-500 text-white px-6 py-3 rounded-xl shadow-md hover:bg-pink-600 transition">
            Start Adopting
        </a>
    </section>

    <!-- Tips & Fun Facts Section -->
    <section class="max-w-6xl mx-auto mt-16 px-6">
        <h3 class="text-3xl font-bold text-center text-gray-800 mb-12">🎯 Cat Tips & Fun Facts</h3>

        @php
            $tips = [
                ["image" => "images/cats/kaycee.jpg", "text" => "😸 Cats sleep for 12-16 hours a day – that's a lot of napping!"],
                ["image" => "images/cats/saplad.jpg", "text" => "💖 Playing with your cat strengthens your bond and keeps them healthy."],
                ["image" => "images/cats/hara.jpg", "text" => "🐾 Cats can make over 100 different sounds!"],
                ["image" => "images/cats/jay.jpg", "text" => "💦 Always provide fresh water – cats are picky drinkers!"],
                ["image" => "images/cats/rj.jpg", "text" => "🎀 A cat’s whiskers help them navigate tight spaces."],
                ["image" => "images/cats/arlene.jpg", "text" => "🌞 Cats love sunny spots – they are natural sunbathers!"],
                ["image" => "images/cats/leo.jpg", "text" => "🍃 Indoor plants can be fun for cats, but avoid toxic ones!"],
                ["image" => "images/cats/vhenjie.jpg", "text" => "🏠 Cats enjoy cozy hiding spots – give them a safe space."],
                ["image" => "images/cats/dawn.jpg", "text" => "🐟 Some cats enjoy a little fish-flavored treat occasionally."],
                ["image" => "images/cats/yuki.jpg", "text" => "🧶 Scratching posts keep your cat’s claws healthy and furniture safe!"]
            ];
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
            @foreach ($tips as $tip)
                <div class="bg-white rounded-3xl shadow-lg overflow-hidden flex flex-col md:flex-row hover:shadow-2xl transition duration-300 transform hover:-translate-y-1">
                    <!-- Left: Cat Image -->
                    <div class="md:w-1/2 flex items-center justify-center bg-pink-50">
                        <img src="{{ asset($tip['image']) }}" alt="Cat"
                             class="w-full h-96 object-cover rounded-t-3xl md:rounded-l-3xl md:rounded-tr-none">
                    </div>

                    <!-- Right: Tip Text -->
                    <div class="md:w-1/2 p-10 flex flex-col justify-center bg-gradient-to-tr from-pink-50 via-purple-50 to-blue-50">
                        <p class="text-gray-800 text-xl md:text-2xl leading-relaxed font-medium">{{ $tip['text'] }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Footer -->
    <footer class="text-center py-6 mt-16 text-gray-600">
        © {{ date('Y') }} Cat Adoption Center. All rights reserved.
    </footer>
</div>
@endsection
