<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manajemen Promo') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-end mb-4">
                        <a href="{{ route('admin.promos.create') }}"
                            class="inline-flex items-center px-4 py-2 bg-primary-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-primary-700">
                            Tambah Promo
                        </a>
                    </div>

                    @if (session('success'))
                        <div class="mb-4 text-sm text-green-600">{{ session('success') }}</div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-4 py-3">Nama Promo</th>
                                    <th scope="col" class="px-4 py-3">Produk</th>
                                    <th scope="col" class="px-4 py-3">Tipe Diskon</th>
                                    <th scope="col" class="px-4 py-3">Nilai</th>
                                    <th scope="col" class="px-4 py-3">Periode</th>
                                    <th scope="col" class="px-4 py-3">Status</th>
                                    <th scope="col" class="px-4 py-3 text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($promos as $promo)
                                    <tr class="border-b dark:border-gray-700">
                                        <td class="px-4 py-3">{{ $promo->name }}</td>
                                        <td class="px-4 py-3">{{ $promo->product->name }}</td>
                                        <td class="px-4 py-3">{{ ucwords($promo->type) }}</td>
                                        <td class="px-4 py-3">
                                            @if ($promo->type == 'percentage')
                                                {{ $promo->value }}%
                                            @else
                                                Rp {{ number_format($promo->value, 0, ',', '.') }}
                                            @endif
                                        </td>
                                        <td class="px-4 py-3">
                                            {{ $promo->start_date ? \Carbon\Carbon::parse($promo->start_date)->format('d M Y') : 'N/A' }}
                                            -
                                            {{ $promo->end_date ? \Carbon\Carbon::parse($promo->end_date)->format('d M Y') : 'N/A' }}
                                        </td>
                                        <td class="px-4 py-3">
                                            @if ($promo->is_valid)
                                                <span
                                                    class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Aktif</span>
                                            @else
                                                <span
                                                    class="bg-red-100 text-red-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">Tidak
                                                    Aktif</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3">
                                            <label class="inline-flex items-center cursor-pointer">
                                                <input type="checkbox" data-promo-id="{{ $promo->id }}"
                                                    class="sr-only peer toggle-status" @checked($promo->is_active)>
                                                <div
                                                    class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600 dark:peer-checked:bg-blue-600">
                                                </div>
                                            </label>
                                        </td>
                                        <td class="px-4 py-3 flex items-center justify-end">
                                            <a href="{{ route('admin.promos.edit', $promo) }}"
                                                class="font-medium text-primary-600 dark:text-primary-500 hover:underline">Edit</a>
                                            <form action="{{ route('admin.promos.destroy', $promo) }}" method="POST"
                                                onsubmit="return confirm('Yakin ingin menghapus?');"
                                                class="inline-block ml-4">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="font-medium text-red-600 dark:text-red-500 hover:underline">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-4 py-3 text-center">Belum ada promo.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        {{ $promos->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.toggle-status').forEach(toggle => {
                toggle.addEventListener('change', function() {
                    const promoId = this.dataset.promoId;
                    const isActive = this.checked;

                    fetch(`{{ url('admin/promos') }}/${promoId}/toggle-status`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            },
                            body: JSON.stringify({
                                is_active: isActive
                            }),
                        }).then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                console.log('Status promo berhasil diperbarui.');
                            } else {
                                alert('Gagal memperbarui status promo.');
                                this.checked = !isActive; // Kembalikan status toggle jika gagal
                            }
                        }).catch(error => {
                            console.error('Error:', error);
                            alert('Terjadi kesalahan server.');
                            this.checked = !isActive; // Kembalikan status toggle jika gagal
                        });
                });
            });
        });
    </script>
@endpush
