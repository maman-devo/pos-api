<x-app-layout>
    {{-- <x-slot name="header">
        
    </x-slot> --}}

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div
                class="relative bg-gradient-to-br from-[#025863] to-[#047481] p-8 rounded-2xl shadow-lg mb-8 overflow-hidden">
                <div class="absolute inset-0 z-0 opacity-10"
                    style="background-image: url('data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 80 80\' width=\'80\' height=\'80\'%3E%3Cpath fill=\'%23FFFFFF\' fill-opacity=\'0.4\' d=\'M14 16H9v-2h5V9.87a4 4 0 1 1 2 0V14h5v2h-5v5.13a4 4 0 1 1-2 0V16zm42 24h-5v-2h5v-4.13a4 4 0 1 1 2 0V38h5v2h-5v5.13a4 4 0 1 1-2 0V40zm-3-22a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm-32-8a4 4 0 1 1 0-8 4 4 0 0 1 0 8z\'%3E%3C/path%3E%3C/svg%3E');">
                </div>

                <div class="flex justify-between items-center">
                    <div class="relative z-10">
                        <h2 class="text-3xl font-bold text-white">Halo, {{ Auth::user()->name }}!</h2>
                        <p class="mt-2 text-gray-200">Bagaimana kabarmu hari ini, semoga menyenangkan.
                        </p>

                        <div class="mt-6">
                            <span class="text-sm text-gray-300">Total Pendapatan
                                ({{ ucfirst($range) }})</span>
                            <p class="text-4xl font-bold text-white">Rp
                                {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                        </div>
                    </div>

                    <div class="relative hidden md:flex flex-col items-end">
                        <img src="{{ asset('images/card-header-img.png') }}" class="h-48 w-auto z-10"
                            alt="Illustration">

                        <div class="mt-4 flex items-center space-x-2">
                            <a href="{{ route('dashboard', ['range' => 'today']) }}"
                                class="flex items-center px-4 py-2 text-sm font-medium rounded-lg {{ $range === 'today' ? 'bg-[#00d47f] text-[#025863]' : 'bg-[#2a737d] text-gray-200 hover:bg-opacity-98' }}">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                    </path>
                                </svg>
                                Hari ini
                            </a>
                            <a href="{{ route('dashboard', ['range' => 'weekly']) }}"
                                class="flex items-center px-4 py-2 text-sm font-medium rounded-lg {{ $range === 'weekly' ? 'bg-[#00d47f] text-[#025863]' : 'bg-[#2a737d] text-gray-200 hover:bg-opacity-98' }}">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                                </svg>
                                Minggu ini
                            </a>
                            <a href="{{ route('dashboard', ['range' => '3months']) }}"
                                class="flex items-center px-4 py-2 text-sm font-medium rounded-lg {{ $range === '3months' ? 'bg-[#00d47f] text-[#025863]' : 'bg-[#2a737d] text-gray-200 hover:bg-opacity-98' }}">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v10a1 1 0 01-1 1H4a1 1 0 01-1-1V10zM15 10a1 1 0 011-1h2a1 1 0 011 1v10a1 1 0 01-1 1h-2a1 1 0 01-1-1V10z">
                                    </path>
                                </svg>
                                3 Bulan ini
                            </a>
                        </div>
                    </div>
                </div>
            </div>


            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm flex items-start space-x-4">
                    <div class="flex-shrink-0 bg-blue-100 dark:bg-blue-900/50 p-3 rounded-full">
                        <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Sales</h3>
                        <p class="text-3xl font-bold text-gray-800 dark:text-gray-100 mt-1">
                            {{ number_format($totalSales) }}</p>
                    </div>
                    <div class="flex-1">
                        <canvas id="salesChart" height="50"></canvas>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm flex items-start space-x-4">
                    <div class="flex-shrink-0 bg-green-100 dark:bg-green-900/50 p-3 rounded-full">
                        <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.653-.125-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Customers</h3>
                        <p class="text-3xl font-bold text-gray-800 dark:text-gray-100 mt-1">
                            {{ number_format($totalCustomers) }}</p>
                    </div>
                    <div class="flex-1">
                        <canvas id="customerChart" height="50"></canvas>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm flex items-start space-x-4">
                    <div class="flex-shrink-0 bg-purple-100 dark:bg-purple-900/50 p-3 rounded-full">
                        <svg class="w-6 h-6 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Products</h3>
                        <p class="text-3xl font-bold text-gray-800 dark:text-gray-100 mt-1">
                            {{ number_format($totalProducts) }}</p>
                    </div>
                    <div class="flex-1">
                        <canvas id="productChart" height="50"></canvas>
                    </div>
                </div>
                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm flex items-start space-x-4">
                    <div class="flex-shrink-0 bg-orange-100 dark:bg-orange-900/50 p-3 rounded-full">
                        <svg class="w-6 h-6 text-orange-600 dark:text-orange-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v.01M12 12v.01M12 12v.01M12 16v.01M12 16v.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Revenue</h3>
                        <p class="text-3xl font-bold text-gray-800 dark:text-gray-100 mt-1">Rp
                            {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                    </div>
                    <div class="flex-1">
                        <canvas id="revenueChart" height="50"></canvas>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
                <div class="lg:col-span-2 bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Revenue Analytics</h3>
                    <div class="h-80">
                        <canvas id="dailyRevenueChart"></canvas>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-sm">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Total Income</h3>
                    <div class="h-80">
                        <canvas id="monthlyRevenueChart"></canvas>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-2xl">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-semibold mb-4">Recent Orders</h3>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                <tr>
                                    <th scope="col" class="px-4 py-3">Order ID</th>
                                    <th scope="col" class="px-4 py-3">Date</th>
                                    <th scope="col" class="px-4 py-3">Customer (Cashier)</th>
                                    <th scope="col" class="px-4 py-3">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($recentTransactions as $transaction)
                                    <tr class="border-b dark:border-gray-700">
                                        <th scope="row"
                                            class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $transaction->transaction_code }}</th>
                                        <td class="px-4 py-3">{{ $transaction->created_at->format('d M Y') }}</td>
                                        <td class="px-4 py-3">{{ $transaction->user->name ?? 'N/A' }}</td>
                                        <td class="px-4 py-3">Rp
                                            {{ number_format($transaction->total_amount, 0, ',', '.') }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-4 py-3 text-center">Belum ada transaksi.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Data dari Controller
                const dailyLabels = @json($dailyLabels);
                const dailyData = @json($dailyData);
                const monthlyLabels = @json($monthlyLabels);
                const monthlyData = @json($monthlyData);

                // Data Chart Mini
                const salesChartData = @json($salesChart);
                const revenueChartData = @json($revenueChart);
                const customerChartData = @json($customerChart);
                const productChartData = @json($productChart);

                // Opsi Umum untuk Chart Utama
                const chartOptions = (isDarkMode) => ({
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: isDarkMode ? '#374151' : '#fff',
                            titleColor: isDarkMode ? '#e5e7eb' : '#374151',
                            bodyColor: isDarkMode ? '#d1d5db' : '#6b7280',
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.parsed.y !== null) {
                                        label += 'Rp ' + new Intl.NumberFormat('id-ID').format(context
                                            .parsed.y);
                                    }
                                    return label;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                color: isDarkMode ? '#9ca3af' : '#6b7280',
                                callback: function(value) {
                                    if (value >= 1000000) return 'Rp ' + (value / 1000000) + ' Jt';
                                    if (value >= 1000) return 'Rp ' + (value / 1000) + ' Rb';
                                    return 'Rp ' + value;
                                }
                            },
                            grid: {
                                color: isDarkMode ? 'rgba(255, 255, 255, 0.1)' : 'rgba(0, 0, 0, 0.1)'
                            }
                        },
                        x: {
                            ticks: {
                                color: isDarkMode ? '#9ca3af' : '#6b7280'
                            },
                            grid: {
                                display: false
                            }
                        }
                    }
                });

                // Opsi Khusus untuk Chart Mini
                const miniChartOptions = (isDarkMode, color) => ({
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            enabled: false
                        }
                    },
                    scales: {
                        y: {
                            display: false,
                            beginAtZero: true
                        },
                        x: {
                            display: false
                        }
                    },
                    elements: {
                        bar: {
                            backgroundColor: color,
                            borderRadius: 2
                        }
                    }
                });

                const isDarkMode = document.documentElement.classList.contains('dark');

                // 1. Grafik Pendapatan Harian (Revenue Analytics)
                const dailyCtx = document.getElementById('dailyRevenueChart').getContext('2d');
                new Chart(dailyCtx, {
                    type: 'bar',
                    data: {
                        labels: dailyLabels,
                        datasets: [{
                            label: 'Pendapatan',
                            data: dailyData,
                            backgroundColor: '#2563eb', // Warna biru dari primary-600
                            borderRadius: 6,
                            barPercentage: 0.5,
                        }]
                    },
                    options: chartOptions(isDarkMode)
                });

                // 2. Grafik Pendapatan Bulanan (Total Income)
                const monthlyCtx = document.getElementById('monthlyRevenueChart').getContext('2d');
                new Chart(monthlyCtx, {
                    type: 'bar',
                    data: {
                        labels: monthlyLabels,
                        datasets: [{
                            label: 'Pendapatan',
                            data: monthlyData,
                            backgroundColor: '#ea580c', // Warna oranye-600
                            borderRadius: 6,
                            barPercentage: 0.5,
                        }]
                    },
                    options: chartOptions(isDarkMode)
                });

                // 3. Grafik Mini Total Sales
                const salesCtx = document.getElementById('salesChart').getContext('2d');
                new Chart(salesCtx, {
                    type: 'bar',
                    data: {
                        labels: Array(salesChartData.length).fill(''),
                        datasets: [{
                            data: salesChartData,
                            backgroundColor: '#60a5fa', // Warna biru cerah
                        }]
                    },
                    options: miniChartOptions(isDarkMode, '#60a5fa')
                });

                // 4. Grafik Mini Total Customers
                const customerCtx = document.getElementById('customerChart').getContext('2d');
                new Chart(customerCtx, {
                    type: 'bar',
                    data: {
                        labels: Array(customerChartData.length).fill(''),
                        datasets: [{
                            data: customerChartData,
                            backgroundColor: '#4ade80', // Warna hijau cerah
                        }]
                    },
                    options: miniChartOptions(isDarkMode, '#4ade80')
                });

                // 5. Grafik Mini Total Products
                const productCtx = document.getElementById('productChart').getContext('2d');
                new Chart(productCtx, {
                    type: 'bar',
                    data: {
                        labels: Array(productChartData.length).fill(''),
                        datasets: [{
                            data: productChartData,
                            backgroundColor: '#a855f7', // Warna ungu cerah
                        }]
                    },
                    options: miniChartOptions(isDarkMode, '#a855f7')
                });

                // 6. Grafik Mini Total Revenue
                const revenueCtx = document.getElementById('revenueChart').getContext('2d');
                new Chart(revenueCtx, {
                    type: 'bar',
                    data: {
                        labels: Array(revenueChartData.length).fill(''),
                        datasets: [{
                            data: revenueChartData,
                            backgroundColor: '#f97316', // Warna oranye
                        }]
                    },
                    options: miniChartOptions(isDarkMode, '#f97316')
                });

            });
        </script>
    @endpush
</x-app-layout>
