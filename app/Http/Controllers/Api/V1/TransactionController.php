<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TransactionController extends Controller
{
    /**
     * Menyimpan transaksi baru ke database.
     */
    public function store(Request $request)
    {
        // 1. Validasi data yang dikirim dari Flutter
        $validated = $request->validate([
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'payment_method' => 'required|string',
            'paid_amount' => 'required|numeric',
        ]);

        $totalAmount = 0;
        // 2. Hitung total belanja dan periksa stok
        foreach ($validated['items'] as $item) {
            $product = Product::find($item['product_id']);
            if ($product->stock < $item['quantity']) {
                return response()->json(['message' => 'Stok untuk produk ' . $product->name . ' tidak mencukupi.'], 422);
            }
            $totalAmount += $product->price * $item['quantity'];
        }

        try {
            // 3. Gunakan DB Transaction untuk memastikan semua query berhasil
            DB::beginTransaction();

            // 4. Buat record di tabel 'transactions'
            $transaction = Transaction::create([
                'user_id' => auth()->id(), // ID kasir yang sedang login
                'transaction_code' => 'TRX-' . Str::random(10),
                'total_amount' => $totalAmount,
                'payment_method' => $validated['payment_method'],
                'paid_amount' => $validated['paid_amount'],
                'change_amount' => $validated['paid_amount'] - $totalAmount,
            ]);

            // 5. Buat record di 'transaction_details' dan kurangi stok
            foreach ($validated['items'] as $item) {
                $product = Product::find($item['product_id']);
                $transaction->details()->create([
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'price' => $product->price,
                ]);

                // Kurangi stok produk
                $product->decrement('stock', $item['quantity']);
            }

            // Jika semua berhasil, commit transaksi
            DB::commit();

            // 6. Kembalikan respons sukses dengan data transaksi
            return response()->json($transaction->load('details.product'), 201);
        } catch (\Exception $e) {
            // Jika ada error, rollback semua query
            DB::rollBack();
            return response()->json(['message' => 'Gagal membuat transaksi, terjadi kesalahan server.', 'error' => $e->getMessage()], 500);
        }
    }
}