<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Logika filter rentang waktu
        $range = $request->query('range', 'today');
        $startDate = Carbon::now()->startOfDay();
        $endDate = Carbon::now()->endOfDay();
        if ($range === 'weekly') {
            $startDate = Carbon::now()->startOfWeek();
        }
        if ($range === '3months') {
            $startDate = Carbon::now()->subMonths(3)->startOfDay();
        }

        // Data untuk Kartu Statistik (sesuai filter)
        $totalRevenue = Transaction::whereBetween('created_at', [$startDate, $endDate])->sum('total_amount');
        $totalSales = Transaction::whereBetween('created_at', [$startDate, $endDate])->count();
        $totalCustomers = User::count();
        $totalProducts = Product::count();

        // DATA BARU: Untuk Grafik Mini pada Kartu Statistik (tren 7 hari terakhir)
        $last7Days = Carbon::now()->subDays(6)->startOfDay()->toPeriod(Carbon::now()->endOfDay());

        // 1. Data Grafik Total Sales
        $salesChartData = Transaction::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))
            ->where('created_at', '>=', $last7Days->getStartDate())
            ->groupBy('date')->pluck('total', 'date');
        $salesChart = $this->generateChartData($last7Days, $salesChartData);

        // 2. Data Grafik Total Revenue
        $revenueChartData = Transaction::select(DB::raw('DATE(created_at) as date'), DB::raw('sum(total_amount) as total'))
            ->where('created_at', '>=', $last7Days->getStartDate())
            ->groupBy('date')->pluck('total', 'date');
        $revenueChart = $this->generateChartData($last7Days, $revenueChartData);

        // 3. Data Grafik Pelanggan Baru
        $customerChartData = User::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))
            ->where('created_at', '>=', $last7Days->getStartDate())
            ->groupBy('date')->pluck('total', 'date');
        $customerChart = $this->generateChartData($last7Days, $customerChartData);

        // 4. Data Grafik Produk Baru
        $productChartData = Product::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))
            ->where('created_at', '>=', $last7Days->getStartDate())
            ->groupBy('date')->pluck('total', 'date');
        $productChart = $this->generateChartData($last7Days, $productChartData);


        // Data untuk Grafik Utama (biarkan seperti semula)
        $chartStartDate = ($range === 'weekly' || $range === '3months') ? $startDate : Carbon::now()->subDays(6)->startOfDay();
        $dailyRevenueData = Transaction::select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total_amount) as total'))
            ->whereBetween('created_at', [$chartStartDate, $endDate])->groupBy('date')->orderBy('date', 'ASC')->get();
        $dailyLabels = [];
        $dailyData = [];
        $period = $chartStartDate->toPeriod($endDate);
        foreach ($period as $date) {
            $dateString = $date->format('Y-m-d');
            $dailyLabels[] = $date->format('d M');
            $sale = $dailyRevenueData->firstWhere('date', $dateString);
            $dailyData[] = $sale ? $sale->total : 0;
        }

        // --- Perbaikan untuk chart bulanan ---
        $monthlyRevenueData = Transaction::select(DB::raw('MONTH(created_at) as month'), DB::raw('SUM(total_amount) as total'))
            ->whereYear('created_at', Carbon::now()->year)
            ->groupBy('month')
            ->orderBy('month', 'ASC')
            ->get();
        $monthlyLabels = [];
        $monthlyData = [];
        for ($i = 1; $i <= 12; $i++) {
            $monthData = $monthlyRevenueData->firstWhere('month', $i);
            $monthlyLabels[] = Carbon::create(null, $i, 1)->format('F');
            $monthlyData[] = $monthData ? $monthData->total : 0;
        }
        // --- Akhir perbaikan ---

        // Data untuk tabel transaksi terbaru
        $recentTransactions = Transaction::with('user')->latest()->take(5)->get();

        return view('dashboard', compact(
            'totalRevenue',
            'totalSales',
            'totalCustomers',
            'totalProducts',
            'salesChart',
            'revenueChart',
            'customerChart',
            'productChart',
            'dailyLabels',
            'dailyData',
            'monthlyLabels', // <-- Tambahkan ini
            'monthlyData',   // <-- Tambahkan ini
            'recentTransactions',
            'range'
        ));
    }

    /**
     * Helper function untuk menghasilkan data grafik harian.
     */
    private function generateChartData($period, $data)
    {
        $chartData = [];
        foreach ($period as $date) {
            $chartData[] = $data[$date->format('Y-m-d')] ?? 0;
        }
        return $chartData;
    }
}