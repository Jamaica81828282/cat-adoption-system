<div class="bg-white rounded-2xl shadow-lg p-8">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">Manage Applications</h2>
        <span class="text-sm text-gray-500">Total: {{ $applications->count() }}</span>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-200 rounded-lg">
            <thead class="bg-gradient-to-r from-indigo-500 to-purple-500 text-white">
                <tr>
                    <th class="px-6 py-3 text-left text-sm font-semibold uppercase">User</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold uppercase">Cat</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-sm font-semibold uppercase">Action</th>
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
                        <td class="px-6 py-4 space-x-2">
    @if($app->status === 'pending')
        <form action="{{ route('admin.applications.updateStatus', $app->id) }}" method="POST" class="inline">
            @csrf
            <input type="hidden" name="status" value="approved">
            <button type="submit" class="px-3 py-1 bg-green-500 text-white text-sm rounded-lg hover:bg-green-600">
                Approve
            </button>
        </form>

        <form action="{{ route('admin.applications.updateStatus', $app->id) }}" method="POST" class="inline">
            @csrf
            <input type="hidden" name="status" value="declined">
            <button type="submit" class="px-3 py-1 bg-red-500 text-white text-sm rounded-lg hover:bg-red-600">
                Decline
            </button>
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
