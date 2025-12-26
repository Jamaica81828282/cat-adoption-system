<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-pink-200 via-purple-200 to-blue-200 relative overflow-hidden py-12">

        <!-- Decorative Pawprints Background (Outside Form) -->
        <div class="absolute inset-0 pointer-events-none select-none">
            <!-- Bouncing Pawprints -->
            <div class="text-[6rem] absolute top-10 left-10 animate-bounce-slow">🐾</div>
            <div class="text-[6rem] absolute bottom-20 right-16 animate-bounce-slow">🐾</div>
            <div class="text-[6rem] absolute top-1/2 left-1/3 animate-bounce-slow">🐱</div>
            <div class="text-[8rem] absolute top-1/3 right-1/4 opacity-20 animate-bounce-slow">🐾</div>

            <!-- Floating Paw Animation -->
            <div class="absolute text-[5rem] top-1/4 left-[-10%] opacity-20 animate-float-paw">🐾</div>
            <div class="absolute text-[4rem] top-3/4 left-[-12%] opacity-15 animate-float-paw delay-500">🐱</div>
            <div class="absolute text-[6rem] top-1/3 left-[-8%] opacity-10 animate-float-paw delay-1000">🐾</div>
        </div>

        <!-- Login Form Container -->
        <div class="relative bg-white/90 backdrop-blur-md shadow-2xl rounded-2xl p-10 w-full max-w-md border border-purple-200 z-10">
            <div class="text-center mb-6">
                <h1 class="text-3xl font-extrabold text-gray-800 mb-2">🐾 Welcome Back!</h1>
                <p class="text-gray-500">Log in to your cat adoption account 🐱</p>
            </div>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <!-- Login Form -->
            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                        placeholder="🐾 Enter your email"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-400 focus:border-transparent">
                    <x-input-error :messages="$errors->get('email')" class="mt-1" />
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input id="password" type="password" name="password" required
                        placeholder="🐱 Enter your password"
                        class="w-full border border-gray-300 rounded-lg px-4 py-2 text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-400 focus:border-transparent">
                    <x-input-error :messages="$errors->get('password')" class="mt-1" />
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" name="remember" class="rounded border-gray-300 text-purple-500 shadow-sm focus:ring-purple-400">
                        <span class="ms-2 text-sm text-gray-600">Remember me 🐾</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a class="text-sm text-purple-500 hover:underline" href="{{ route('password.request') }}">
                            Forgot your password?
                        </a>
                    @endif
                </div>

                <!-- Submit Button -->
                <div class="pt-2">
                    <button type="submit"
                        class="w-full bg-purple-500 hover:bg-purple-600 text-white font-semibold py-2 rounded-lg shadow-md transition duration-200 ease-in-out">
                        🐈 Log In
                    </button>
                </div>

                <p class="text-center text-sm text-gray-600 mt-4">
                    Don’t have an account?
                    <a href="{{ route('register') }}" class="text-purple-500 hover:underline font-medium">
                        Sign up here 🐱
                    </a>
                </p>
            </form>
        </div>
    </div>

    <!-- Optional: Add a small Tailwind animation -->
    <style>
        @keyframes bounce-slow {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        .animate-bounce-slow {
            animation: bounce-slow 3s ease-in-out infinite;
        }

        @keyframes float-paw {
            0% { transform: translateX(0) translateY(0) rotate(0deg); }
            50% { transform: translateX(110vw) translateY(-20vh) rotate(360deg); }
            100% { transform: translateX(220vw) translateY(0) rotate(720deg); }
        }
        .animate-float-paw {
            animation: float-paw 30s linear infinite;
        }
        .delay-500 { animation-delay: 5s; }
        .delay-1000 { animation-delay: 10s; }
    </style>
</x-guest-layout>
