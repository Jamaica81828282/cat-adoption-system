
@extends('layouts.admin')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-pink-100 via-purple-100 to-blue-100 py-12">
    <div class="max-w-7xl mx-auto px-6">
        <h1 class="text-3xl font-extrabold text-gray-800 mb-8 text-center">📋 Manage Applications</h1>

        <div class="bg-white rounded-3xl shadow-2xl p-8 border border-pink-200">
            <div class="overflow-x-auto">
                <table class="min-w-full border-collapse rounded-xl overflow-hidden">
                    <thead class="bg-gradient-to-r from-pink-400 via-purple-400 to-blue-400 text-white">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold uppercase">User</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold uppercase">Cat</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold uppercase">Status</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold uppercase">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($applications as $app)
                            <tr class="border-b hover:bg-pink-50 transition">
                                <td class="px-6 py-4 text-gray-800 font-medium">{{ $app->user->name }}</td>
                                <td class="px-6 py-4 text-gray-700">{{ $app->cat->name }}</td>
                                <td class="px-6 py-4">
                                    <span class="px-3 py-1 rounded-full text-sm font-semibold
                                        @if($app->status === 'approved') bg-green-100 text-green-700
                                        @elseif($app->status === 'pending') bg-yellow-100 text-yellow-700
                                        @else bg-red-100 text-red-700 @endif">
                                        {{ ucfirst($app->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 space-x-2">
                                    @if($app->status === 'pending')
                                        <form action="{{ route('admin.applications.updateStatus', $app->id) }}" method="POST" class="inline">
                                            @csrf
                                            <input type="hidden" name="status" value="approved">
                                            <button type="submit" class="px-3 py-1 bg-green-500 text-white text-sm rounded-2xl hover:bg-green-600 transition transform hover:-translate-y-0.5">Approve</button>
                                        </form>
                                        <form action="{{ route('admin.applications.updateStatus', $app->id) }}" method="POST" class="inline">
                                            @csrf
                                            <input type="hidden" name="status" value="declined">
                                            <button type="submit" class="px-3 py-1 bg-red-500 text-white text-sm rounded-2xl hover:bg-red-600 transition transform hover:-translate-y-0.5">Decline</button>
                                        </form>
                                    @else
                                        <span class="text-gray-500">No actions</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-gray-500">
                                    No applications found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection