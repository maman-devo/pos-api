<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Produk') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <!-- Notifikasi Sukses -->
                    @if (session('success'))
                        <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Tombol Tambah Produk -->
                    <a href="{{ route('admin.products.create') }}" class="text-white bg-blue-700 hover:bg-blue-800 ...">
                        Tambah Produk Baru
                    </a>

                    <!-- Tabel Produk -->
                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-4">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Nama Produk</th>
                                    <th scope="col" class="px-6 py-3">Kategori</th>
                                    <th scope="col" class="px-6 py-3">Harga</th>
                                    <th scope="col" class="px-6 py-3">Stok</th>
                                    <th scope="col" class="px-6 py-3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($products as $product)
                                    <tr class="bg-white border-b hover:bg-gray-50">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                            {{ $product->name }}
                                        </th>
                                        <td class="px-6 py-4">{{ $product->category->name }}</td>
                                        <td class="px-6 py-4">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                                        <td class="px-6 py-4">{{ $product->stock }}</td>
                                        <td class="px-6 py-4 flex items-center">
                                            <a href="{{ route('admin.products.edit', $product->id) }}"
                                                class="font-medium text-blue-600 hover:underline">Edit</a>
                                            <form action="{{ route('admin.products.destroy', $product->id) }}"
                                                method="POST"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?');"
                                                class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="font-medium text-red-600 hover:underline ms-3">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center">Tidak ada data produk.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $products->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
