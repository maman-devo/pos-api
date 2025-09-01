<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Menampilkan daftar semua transaksi.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        $perPage = $request->query('perPage', 10);

        $transactions = Transaction::with('user')
            ->when($search, function ($query, $search) {
                return $query->where('transaction_code', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            })
            ->latest()
            ->paginate($perPage)
            ->withQueryString();

        return view('admin.transactions.index', compact('transactions', 'search', 'perPage'));
    }

    /**
     * Menampilkan detail dari satu transaksi.
     */
    public function show(Transaction $transaction)
    {
        // Load relasi transactionDetails beserta produk di dalamnya
        $transaction->load('transactionDetails.product');

        return view('admin.transactions.show', compact('transaction'));
    }
}