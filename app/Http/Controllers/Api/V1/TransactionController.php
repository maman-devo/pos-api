<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use App\Models\User; // <-- Tambahkan ini
use App\Models\Notification; // <-- Tambahkan ini
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class TransactionController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
            'payment_method_code' => 'required|string|exists:payment_methods,code',
            'paid_amount' => 'required|numeric|min:0',
        ]);

        $paymentMethod = PaymentMethod::where('code', $request->payment_method_code)->first();
        if (!$paymentMethod || !$paymentMethod->is_active) {
            return response()->json(['message' => 'Metode pembayaran tidak valid atau tidak aktif.'], 422);
        }

        if ($paymentMethod->code !== 'cash') {
            return response()->json(['message' => 'Metode pembayaran non-tunai belum didukung.'], 422);
        }

        DB::beginTransaction();
        try {
            // ... (Kalkulasi total dan validasi stok tetap sama) ...
            $totalAmount = 0;
            foreach ($request->items as $item) {
                $product = Product::find($item['product_id']);
                if ($product->stock < $item['quantity']) {
                    throw new \Exception('Stok produk ' . $product->name . ' tidak mencukupi.');
                }

                $price = $this->calculatePriceWithPromo($product);
                $totalAmount += $price * $item['quantity'];
            }

            if ($request->paid_amount < $totalAmount) {
                throw new \Exception('Jumlah pembayaran tunai tidak mencukupi.');
            }

            // Buat transaksi di database
            $transaction = Transaction::create([
                'user_id' => auth()->id(),
                'transaction_code' => 'TRX-' . time(),
                'total_amount' => $totalAmount,
                'payment_method' => $paymentMethod->name,
                'paid_amount' => $request->paid_amount,
                'change_amount' => $request->paid_amount - $totalAmount,
                'status' => 'paid',
            ]);

            // ... (Simpan detail transaksi dan kurangi stok tetap sama) ...
            foreach ($request->items as $item) {
                $product = Product::find($item['product_id']);
                TransactionDetail::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $product->id,
                    'quantity' => $item['quantity'],
                    'price' => $this->calculatePriceWithPromo($product),
                ]);
                $product->decrement('stock', $item['quantity']);
            }

            // === BUAT NOTIFIKASI UNTUK SEMUA ADMIN ===
            $admins = User::where('role', 'admin')->get();
            foreach ($admins as $admin) {
                Notification::create([
                    'user_id' => $admin->id,
                    'type' => 'new_transaction',
                    'data' => [
                        'transaction_id' => $transaction->id,
                        'transaction_code' => $transaction->transaction_code,
                        'total_amount' => $transaction->total_amount,
                        'cashier_name' => auth()->user()->name,
                    ]
                ]);
            }
            // =======================================

            DB::commit();
            return response()->json($transaction->load('transactionDetails.product'), 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Terjadi kesalahan saat memproses transaksi.', 'error' => $e->getMessage()], 500);
        }
    }

    private function calculatePriceWithPromo(Product $product)
    {
        // ... (Fungsi ini biarkan seperti semula) ...
        $price = $product->price;
        $activePromo = $product->promos()
            ->where('is_active', true)
            ->where(function ($query) {
                $query->whereNull('start_date')->orWhere('start_date', '<=', Carbon::today());
            })
            ->where(function ($query) {
                $query->whereNull('end_date')->orWhere('end_date', '>=', Carbon::today());
            })
            ->first();

        if ($activePromo) {
            $discount = ($price * $activePromo->value) / 100;
            $price = $price - $discount;
        }
        return $price;
    }
}