<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tambah Metode Pembayaran') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('admin.payment-methods.store') }}" method="POST">
                        @csrf
                        <div class="grid gap-6 mb-6 md:grid-cols-2">
                            <div>
                                <label for="name" class="block mb-2 text-sm font-medium">Nama Metode</label>
                                <input type="text" id="name" name="name"
                                    class="bg-gray-50 border border-gray-300 text-sm rounded-lg block w-full p-2.5"
                                    placeholder="Contoh: QRIS Midtrans" required>
                            </div>
                            <div>
                                <label for="code" class="block mb-2 text-sm font-medium">Kode Unik</label>
                                <input type="text" id="code" name="code"
                                    class="bg-gray-50 border border-gray-300 text-sm rounded-lg block w-full p-2.5"
                                    placeholder="Contoh: qris_midtrans" required>
                            </div>
                            <div>
                                <label for="provider" class="block mb-2 text-sm font-medium">Provider</label>
                                <input type="text" id="provider" name="provider"
                                    class="bg-gray-50 border border-gray-300 text-sm rounded-lg block w-full p-2.5"
                                    placeholder="Contoh: midtrans">
                            </div>
                            <div class="flex items-center pt-6">
                                <input id="is_active" name="is_active" type="checkbox" value="1"
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded" checked>
                                <label for="is_active" class="ms-2 text-sm font-medium">Aktifkan Metode</label>
                            </div>
                        </div>
                        <hr class="my-6 border-gray-200 dark:border-gray-700">
                        <h3 class="text-lg font-semibold mb-4">Kredensial API (Opsional)</h3>
                        <div class="grid gap-6 mb-6 md:grid-cols-2">
                            <div>
                                <label for="server_key" class="block mb-2 text-sm font-medium">Server Key</label>
                                <input type="text" id="server_key" name="credentials[server_key]"
                                    class="bg-gray-50 border border-gray-300 text-sm rounded-lg block w-full p-2.5">
                            </div>
                            <div>
                                <label for="client_key" class="block mb-2 text-sm font-medium">Client Key</label>
                                <input type="text" id="client_key" name="credentials[client_key]"
                                    class="bg-gray-50 border border-gray-300 text-sm rounded-lg block w-full p-2.5">
                            </div>
                        </div>
                        <button type="submit"
                            class="text-white bg-primary-700 hover:bg-primary-800 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
