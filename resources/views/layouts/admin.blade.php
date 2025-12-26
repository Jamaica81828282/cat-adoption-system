<!DOCTYPE html>
<html lang="en">
<head>
    @livewireStyles

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans antialiased">

    <!-- 🧭 Admin Navigation Bar -->
<!-- 🧭 Admin Navigation Bar -->
<nav class="bg-white border-b border-gray-200 shadow-sm">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
        <div class="flex items-center space-x-6">
            <h1 class="text-2xl font-bold text-indigo-700">🐾 Admin</h1>

            <!-- Fixed links -->
            <a href="{{ route('admin.dashboard') }}" 
               class="text-gray-700 hover:text-indigo-600 font-medium">Dashboard</a>
            <a href="{{ route('admin.cats.index') }}" 
            class="text-gray-700 hover:text-indigo-600 font-medium">Manage Cats</a>

            <a href="{{ route('admin.applications.index') }}" 
               class="text-gray-700 hover:text-indigo-600 font-medium">Applications</a>
        </div>

       <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
</nav>

    <!-- 🧱 Page Content -->
    <main class="py-6">
        @yield('content')
    </main>
@livewireScripts

</body>
</html>
