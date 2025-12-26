{{-- VS Code: Ignore Blade syntax warnings --}}
@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-pink-100 via-purple-100 to-blue-100 py-12">
    <div class="max-w-7xl mx-auto px-6">

        <h1 class="text-4xl font-extrabold text-gray-800 mb-10 text-center">🐾 Admin Dashboard</h1>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
            <div class="bg-gradient-to-br from-pink-200 via-purple-200 to-blue-200 p-6 rounded-3xl shadow-lg">
                <h2 class="text-lg font-semibold text-gray-800">Total Cats</h2>
                <p class="text-4xl font-bold text-gray-900">{{ $totalCats ?? 0 }}</p>
            </div>

            <div class="bg-gradient-to-br from-green-200 via-teal-200 to-cyan-200 p-6 rounded-3xl shadow-lg">
                <h2 class="text-lg font-semibold text-gray-800">Total Applications</h2>
                <p class="text-4xl font-bold text-gray-900">{{ $totalApplications ?? 0 }}</p>
            </div>

            <div class="bg-gradient-to-br from-yellow-200 via-orange-200 to-pink-200 p-6 rounded-3xl shadow-lg">
                <h2 class="text-lg font-semibold text-gray-800">Registered Users</h2>
                <p class="text-4xl font-bold text-gray-900">{{ $users->count() ?? 0 }}</p>
            </div>
        </div>

        <!-- User Engagement Metrics Section -->
        <div class="bg-white p-6 rounded-3xl shadow-lg mb-10">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center">
                <svg class="w-8 h-8 mr-3 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                User Engagement Metrics
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <!-- Most Active Users -->
                <div class="bg-gradient-to-br from-purple-50 to-pink-50 p-5 rounded-2xl border-2 border-purple-200">
                    <h3 class="text-sm font-semibold text-gray-600 mb-3 uppercase tracking-wide">Most Active Users</h3>
                    
                    @if(isset($mostActiveUsers) && $mostActiveUsers->count() > 0)
                        <div class="space-y-3">
                            @foreach($mostActiveUsers->take(3) as $index => $user)
                                <div class="flex items-center justify-between bg-white p-3 rounded-xl shadow-sm">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-purple-400 to-pink-400 flex items-center justify-center text-white font-bold">
                                            {{ $index + 1 }}
                                        </div>
                                        <div>
                                            <p class="font-semibold text-gray-800">{{ $user->name }}</p>
                                            <p class="text-xs text-gray-500">{{ Str::limit($user->email, 20) }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-lg font-bold text-purple-600">{{ $user->applications_count }}</p>
                                        <p class="text-xs text-gray-500">apps</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-400 text-center py-4">No active users yet</p>
                    @endif
                </div>

                <!-- New Registrations This Week -->
                <div class="bg-gradient-to-br from-blue-50 to-cyan-50 p-5 rounded-2xl border-2 border-blue-200">
                    <h3 class="text-sm font-semibold text-gray-600 mb-3 uppercase tracking-wide">This Week</h3>
                    
                    <div class="text-center mb-4">
                        <p class="text-5xl font-extrabold text-blue-600">{{ $newUsersThisWeek ?? 0 }}</p>
                        <p class="text-sm text-gray-600 mt-2">New Registrations</p>
                    </div>

                    <div class="bg-white p-3 rounded-xl shadow-sm">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-xs text-gray-600">vs Last Week</span>
                            @if(isset($userGrowthPercent) && $userGrowthPercent > 0)
                                <span class="text-green-600 font-semibold flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                    </svg>
                                    +{{ number_format($userGrowthPercent, 1) }}%
                                </span>
                            @elseif(isset($userGrowthPercent) && $userGrowthPercent < 0)
                                <span class="text-red-600 font-semibold flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path>
                                    </svg>
                                    {{ number_format($userGrowthPercent, 1) }}%
                                </span>
                            @else
                                <span class="text-gray-500 font-semibold">0%</span>
                            @endif
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-blue-500 h-2 rounded-full" style="width: {{ min($newUsersThisWeek ?? 0, 100) }}%"></div>
                        </div>
                    </div>
                </div>

                <!-- Application Activity -->
                <div class="bg-gradient-to-br from-green-50 to-teal-50 p-5 rounded-2xl border-2 border-green-200">
                    <h3 class="text-sm font-semibold text-gray-600 mb-3 uppercase tracking-wide">Application Activity</h3>
                    
                    <div class="space-y-4">
                        <div class="bg-white p-4 rounded-xl shadow-sm">
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="text-2xl font-bold text-gray-800">{{ $avgApplicationsPerCat ?? 0 }}</p>
                                    <p class="text-xs text-gray-600 mt-1">Avg Apps per Cat</p>
                                </div>
                                <div class="w-12 h-12 bg-gradient-to-br from-green-400 to-teal-400 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white p-4 rounded-xl shadow-sm">
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="text-2xl font-bold text-gray-800">{{ $applicationsThisWeek ?? 0 }}</p>
                                    <p class="text-xs text-gray-600 mt-1">Apps This Week</p>
                                </div>
                                <div class="w-12 h-12 bg-gradient-to-br from-yellow-400 to-orange-400 rounded-full flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

@endsection