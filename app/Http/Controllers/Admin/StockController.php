<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\StockHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    /**
     * Menampilkan halaman manajemen stok.
     *
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $search = $request->query('search');
        $perPage = $request->query('perPage', 10);

        $products = Product::with('category')
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                    ->orWhereHas('category', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            })
            ->latest()
            ->paginate($perPage)
            ->withQueryString();

        return view('admin.stocks.index', compact('products', 'search', 'perPage'));
    }

    /**
     * Memperbarui stok produk dan mencatat riwayatnya.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'type' => 'required|in:in,out,adjustment',
            'quantity' => 'required|integer|min:0', // Memperbolehkan 0 untuk adjustment
            'remarks' => 'nullable|string|max:255',
        ]);

        try {
            DB::beginTransaction();

            $oldStock = $product->stock;
            $inputQuantity = (int)$request->quantity;
            $quantityChange = 0; // Inisialisasi nilai perubahan stok

            // Logika untuk menentukan stok baru dan jumlah perubahan
            if ($request->type === 'in') {
                $newStock = $oldStock + $inputQuantity;
                $quantityChange = $inputQuantity;
            } elseif ($request->type === 'out') {
                $newStock = $oldStock - $inputQuantity;
                if ($newStock < 0) {
                    // Batalkan jika stok akan menjadi negatif
                    DB::rollBack();
                    return back()->with('error', 'Stok keluar melebihi stok yang tersedia.');
                }
                $quantityChange = -$inputQuantity; // Perubahan adalah negatif
            } else { // Tipe 'adjustment'
                $newStock = $inputQuantity; // Stok baru adalah nilai yang diinput
                $quantityChange = $newStock - $oldStock; // Perubahan adalah selisihnya
            }

            // 1. Update stok di tabel produk
            $product->update(['stock' => $newStock]);

            // 2. Catat riwayat perubahan stok
            StockHistory::create([
                'product_id' => $product->id,
                'user_id' => Auth::id(),
                'type' => $request->type,
                'quantity' => $quantityChange, // Simpan nilai perubahan yang benar
                'remarks' => $request->remarks,
            ]);

            DB::commit();

            return redirect()->route('admin.stocks.index')->with('success', 'Stok produk berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            // Baris di bawah ini bisa diaktifkan untuk melihat error detail saat development
            // return back()->with('error', 'Gagal memperbarui stok. Error: ' . $e->getMessage());
            return back()->with('error', 'Gagal memperbarui stok. Terjadi kesalahan server.');
        }
    }

    public function history()
    {
        // Ambil data riwayat, urutkan dari yang terbaru
        // Gunakan with() untuk memuat relasi product dan user secara efisien
        $histories = StockHistory::with(['product', 'user'])->latest()->paginate(15);

        return view('admin.stocks.history', compact('histories'));
    }
}