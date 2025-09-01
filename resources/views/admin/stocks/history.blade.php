<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Riwayat Perubahan Stok') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="mb-4">
                        <a href="{{ route('admin.stocks.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-300">
                            &larr; Kembali ke Manajemen Stok
                        </a>
                    </div>

                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Tanggal</th>
                                    <th scope="col" class="px-6 py-3">Nama Produk</th>
                                    <th scope="col" class="px-6 py-3 text-center">Tipe Aksi</th>
                                    <th scope="col" class="px-6 py-3 text-center">Jumlah Perubahan</th>
                                    <th scope="col" class="px-6 py-3">Catatan</th>
                                    <th scope="col" class="px-6 py-3">Oleh</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($histories as $history)
                                    <tr class="bg-white border-b hover:bg-gray-50">
                                        <td class="px-6 py-4">{{ $history->created_at->format('d M Y, H:i') }}</td>
                                        <th scope="row"
                                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                            {{ $history->product->name ?? 'N/A' }}</th>
                                        <td class="px-6 py-4 text-center">
                                            @if ($history->type == 'in')
                                                <span
                                                    class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded">Stok
                                                    Masuk</span>
                                            @elseif($history->type == 'out')
                                                <span
                                                    class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded">Stok
                                                    Keluar</span>
                                            @else
                                                <span
                                                    class="bg-yellow-100 text-yellow-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded">Penyesuaian</span>
                                            @endif
                                        </td>
                                        <td
                                            class="px-6 py-4 text-center font-mono font-bold @if ($history->quantity > 0) text-green-600 @else text-red-600 @endif">
                                            {{ $history->quantity > 0 ? '+' : '' }}{{ $history->quantity }}
                                        </td>
                                        <td class="px-6 py-4">{{ $history->remarks ?? '-' }}</td>
                                        <td class="px-6 py-4">{{ $history->user->name ?? 'N/A' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">Belum ada riwayat
                                            perubahan stok.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">{{ $histories->links() }}</div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
