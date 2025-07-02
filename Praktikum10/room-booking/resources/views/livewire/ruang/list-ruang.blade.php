<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-6">List Ruang</h1>

    <!-- Flash Message Alert -->
    @if (session('message'))
        <div class="bg-green-500 text-white p-4 rounded mb-6">
            {{ session('message') }}
        </div>
    @endif

    <div class="flex justify-between items-center mb-6">
        <a href="{{ route('ruang.create') }}" 
           class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
            + New Ruang
        </a>
    </div>

    <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kode</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($ruangs as $ruang)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $ruang->id }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $ruang->kode }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $ruang->nama }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                            {{ $ruang->status == 'Tersedia' ? 'bg-green-100 text-green-800' : 
                               ($ruang->status == 'Dibooking' ? 'bg-blue-100 text-blue-800' : 
                               ($ruang->status == 'Maintenance' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800')) }}">
                            {{ $ruang->status }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <div class="flex space-x-2">
                            <flux:button :href="route('ruang.edit', $ruang)" variant="outline" size="sm">
                                Edit
                            </flux:button>
                            <button wire:click="delete({{ $ruang->id }})"
                                    wire:confirm="Are you sure you want to delete this ruang?"
                                    class="text-red-600 hover:text-red-900">
                                Delete
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    @if ($ruangs->hasPages())
        <div class="mt-4">
            {{ $ruangs->links() }}
        </div>
    @endif
</div>