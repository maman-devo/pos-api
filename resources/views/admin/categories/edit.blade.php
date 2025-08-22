<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Kategori') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('admin.categories.update', $category->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="mb-4">
                            <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Nama
                                Kategori</label>
                            <input type="text" id="name" name="name"
                                value="{{ old('name', $category->name) }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                required>
                        </div>
                        <button type="submit"
                            class="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center">Simpan
                            Perubahan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
