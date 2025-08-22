<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Manajemen Kategori') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (session('success'))
                        <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif

                    <a href="{{ route('admin.categories.create') }}"
                        class="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-4">
                        Tambah Kategori Baru
                    </a>

                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-4">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3">Nama Kategori</th>
                                    <th scope="col" class="px-6 py-3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($categories as $category)
                                    <tr class="bg-white border-b hover:bg-gray-50">
                                        <th scope="row"
                                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                            {{ $category->name }}
                                        </th>
                                        <td class="px-6 py-4 flex items-center">
                                            <a href="{{ route('admin.categories.edit', $category->id) }}"
                                                class="font-medium text-blue-600 hover:underline">Edit</a>
                                            <form action="{{ route('admin.categories.destroy', $category->id) }}"
                                                method="POST" onsubmit="return confirm('Yakin ingin menghapus?');"
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
                                        <td colspan="2" class="px-6 py-4 text-center">Tidak ada data kategori.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">{{ $categories->links() }}</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
