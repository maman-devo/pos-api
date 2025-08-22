<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Kartu Statistik -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-500">Total Pendapatan</h3>
                    <p class="text-3xl font-bold mt-2">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-500">Total Transaksi</h3>
                    <p class="text-3xl font-bold mt-2">{{ $totalTransactions }}</p>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-500">Total Produk</h3>
                    <p class="text-3xl font-bold mt-2">{{ $totalProducts }}</p>
                </div>
            </div>

            <!-- Transaksi Terbaru -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-xl font-semibold mb-4">5 Transaksi Terbaru</h3>
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Kode Transaksi</th>
                                    <th scope="col" class="px-6 py-3">Kasir</th>
                                    <th scope="col" class="px-6 py-3">Total</th>
                                    <th scope="col" class="px-6 py-3">Tanggal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($latestTransactions as $transaction)
                                    <tr class="bg-white border-b hover:bg-gray-50">
                                        <td class="px-6 py-4">{{ $transaction->transaction_code }}</td>
                                        <td class="px-6 py-4">{{ $transaction->user->name ?? 'N/A' }}</td>
                                        <td class="px-6 py-4">Rp
                                            {{ number_format($transaction->total_amount, 0, ',', '.') }}</td>
                                        <td class="px-6 py-4">{{ $transaction->created_at->format('d M Y, H:i') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-center">Belum ada transaksi.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
