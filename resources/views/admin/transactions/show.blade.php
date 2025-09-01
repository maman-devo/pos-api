<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Transaksi: ') }} {{ $transaction->transaction_code }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-2 gap-4 mb-6">
                        <div>
                            <h3 class="text-lg font-bold">Informasi Struk</h3>
                            <p><strong>Kode:</strong> {{ $transaction->transaction_code }}</p>
                            <p><strong>Tanggal:</strong> {{ $transaction->created_at->format('d F Y, H:i:s') }}</p>
                            <p><strong>Kasir:</strong> {{ $transaction->user->name ?? 'N/A' }}</p>
                        </div>
                        <div class="text-right">
                            <h3 class="text-lg font-bold">Total Pembayaran</h3>
                            <p class="text-2xl font-mono">Rp
                                {{ number_format($transaction->total_amount, 0, ',', '.') }}</p>
                            <p><strong>Metode Bayar:</strong>
                                {{ ucwords(str_replace('_', ' ', $transaction->payment_method)) }}</p>
                            <p><strong>Uang Dibayar:</strong> Rp
                                {{ number_format($transaction->paid_amount, 0, ',', '.') }}</p>
                            <p><strong>Kembalian:</strong> Rp
                                {{ number_format($transaction->change_amount, 0, ',', '.') }}</p>
                        </div>
                    </div>

                    <hr class="my-4 border-t-2 border-dashed">

                    <h3 class="text-lg font-bold mb-2">Rincian Produk</h3>
                    <div class="relative overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Produk</th>
                                    <th scope="col" class="px-6 py-3 text-center">Jumlah</th>
                                    <th scope="col" class="px-6 py-3 text-right">Harga Satuan</th>
                                    <th scope="col" class="px-6 py-3 text-right">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transaction->transactionDetails as $detail)
                                    <tr class="bg-white border-b">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                            {{ $detail->product->name }}
                                        </th>
                                        <td class="px-6 py-4 text-center">{{ $detail->quantity }}</td>
                                        <td class="px-6 py-4 text-right">Rp
                                            {{ number_format($detail->price, 0, ',', '.') }}</td>
                                        <td class="px-6 py-4 text-right">Rp
                                            {{ number_format($detail->quantity * $detail->price, 0, ',', '.') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <a href="{{ route('admin.transactions.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                            Kembali ke Riwayat
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
