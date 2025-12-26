<div wire:poll.10s>
    <div class="bg-white rounded-2xl shadow-lg p-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold text-gray-800">Recent Applications</h2>
            <span class="text-sm text-gray-500">Showing {{ $applications->count() }} entries</span>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-200 rounded-lg">
                <thead class="bg-gradient-to-r from-indigo-500 to-purple-500 text-white">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold uppercase">User</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold uppercase">Cat</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold uppercase">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($applications as $app)
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="px-6 py-4 text-gray-700 font-medium">{{ $app->user->name }}</td>
                            <td class="px-6 py-4 text-gray-700">{{ $app->cat->name }}</td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-sm font-semibold
                                    @if($app->status === 'approved') bg-green-100 text-green-700
                                    @elseif($app->status === 'pending') bg-yellow-100 text-yellow-700
                                    @else bg-red-100 text-red-700 @endif">
                                    {{ ucfirst($app->status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-4 text-center text-gray-500">
                                No applications found.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
