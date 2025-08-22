<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalRevenue = Transaction::sum('total_amount');
        $totalTransactions = Transaction::count();
        $totalProducts = Product::count();
        $latestTransactions = Transaction::with('user')->latest()->take(5)->get();

        return view('dashboard', compact(
            'totalRevenue',
            'totalTransactions',
            'totalProducts',
            'latestTransactions'
        ));
    }
}