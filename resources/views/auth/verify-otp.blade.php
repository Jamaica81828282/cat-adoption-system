<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-pink-200 via-purple-200 to-blue-200 relative overflow-hidden py-12">

        <!-- Decorative Pawprints Background -->
        <div class="absolute inset-0 pointer-events-none select-none">
            <div class="text-[6rem] absolute top-10 left-10 animate-bounce-slow">🐾</div>
            <div class="text-[6rem] absolute bottom-20 right-16 animate-bounce-slow">🐾</div>
            <div class="text-[6rem] absolute top-1/2 left-1/3 animate-bounce-slow">🐱</div>
            <div class="text-[8rem] absolute top-1/3 right-1/4 opacity-20 animate-bounce-slow">🐾</div>

            <div class="absolute text-[5rem] top-1/4 left-[-10%] opacity-20 animate-float-paw">🐾</div>
            <div class="absolute text-[4rem] top-3/4 left-[-12%] opacity-15 animate-float-paw delay-500">🐱</div>
            <div class="absolute text-[6rem] top-1/3 left-[-8%] opacity-10 animate-float-paw delay-1000">🐾</div>
        </div>

        <!-- OTP Verification Form Container -->
        <div class="relative bg-white/90 backdrop-blur-md shadow-2xl rounded-2xl p-10 w-full max-w-md border border-purple-200 z-10">
            <div class="text-center mb-6">
                <h1 class="text-3xl font-extrabold text-gray-800 mb-2">🔑 Enter Verification Code</h1>
                <p class="text-gray-500">Check your email for the 6-digit code 🐾</p>
            </div>

            @if (session('status'))
                <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <!-- OTP Verification Form -->
            <form method="POST" action="{{ route('password.verify-otp') }}" class="space-y-5">
                @csrf

                <!-- Email Input - Show field if no email in request, otherwise hide -->
                @if(request('email'))
                    <input type="hidden" name="email" value="{{ request('email') }}">
                    <div class="text-center text-sm text-gray-600 bg-purple-50 border border-purple-200 rounded-lg p-3">
                        Code sent to: <strong>{{ request('email') }}</strong>
                    </div>
                @else
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required
                            placeholder="🐾 Enter your email"
                            class="w-full border border-gray-300 rounded-lg px-4 py-2 text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-400 focus:border-transparent">
                    </div>
                @endif

                <!-- OTP Code -->
                <div>
                    <label for="otp" class="block text-sm font-medium text-gray-700 mb-2 text-center">Verification Code</label>
                    <input id="otp" type="text" name="otp" required autofocus maxlength="6" inputmode="numeric"
                        placeholder="000000"
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 text-gray-700 text-center text-3xl font-bold tracking-[0.5em] placeholder-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-400 focus:border-transparent">
                    <p class="text-xs text-gray-500 text-center mt-2">Enter the 6-digit code from your email</p>
                </div>

                <!-- Submit Button -->
                <div class="pt-2">
                    <button type="submit"
                        class="w-full bg-purple-500 hover:bg-purple-600 text-white font-semibold py-3 rounded-lg shadow-md transition duration-200 ease-in-out">
                        ✅ Verify Code
                    </button>
                </div>

                <div class="text-center space-y-2">
                    <p class="text-sm text-gray-600">
                        Didn't receive the code?
                        <a href="{{ route('password.request') }}" class="text-purple-500 hover:underline font-medium">
                            Resend Code 🐱
                        </a>
                    </p>
                    <p class="text-sm text-gray-600">
                        <a href="{{ route('login') }}" class="text-purple-500 hover:underline font-medium">
                            Back to Login 🐾
                        </a>
                    </p>
                </div>
            </form>
        </div>
    </div>

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

        /* Remove spinner arrows from number input */
        input[type="text"]::-webkit-outer-spin-button,
        input[type="text"]::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
    </style>
</x-guest-layout>