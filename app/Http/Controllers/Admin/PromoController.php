<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Promo;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class PromoController extends Controller
{
    public function index(Request $request)
    {
        $promos = Promo::with('product')->latest()->paginate(10);

        // Logika untuk menentukan apakah promo masih valid (aktif + tanggal berlaku)
        foreach ($promos as $promo) {
            $isValid = $promo->is_active && (
                (!$promo->start_date && !$promo->end_date) ||
                (Carbon::now()->greaterThanOrEqualTo($promo->start_date) && Carbon::now()->lessThanOrEqualTo($promo->end_date))
            );
            $promo->is_valid = $isValid;
        }

        return view('admin.promos.index', compact('promos'));
    }

    public function create()
    {
        $products = Product::orderBy('name')->get();
        return view('admin.promos.create', compact('products'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'product_id' => 'required|exists:products,id',
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'is_active' => 'nullable|boolean',
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');

        Promo::create($data);

        return redirect()->route('admin.promos.index')->with('success', 'Promo berhasil ditambahkan.');
    }

    public function edit(Promo $promo)
    {
        $products = Product::orderBy('name')->get();
        return view('admin.promos.edit', compact('promo', 'products'));
    }

    public function update(Request $request, Promo $promo)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'product_id' => 'required|exists:products,id',
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'is_active' => 'nullable|boolean',
        ]);

        $data = $request->all();
        $data['is_active'] = $request->has('is_active');

        $promo->update($data);

        return redirect()->route('admin.promos.index')->with('success', 'Promo berhasil diperbarui.');
    }

    public function destroy(Promo $promo)
    {
        $promo->delete();
        return redirect()->route('admin.promos.index')->with('success', 'Promo berhasil dihapus.');
    }

    public function toggleStatus(Promo $promo)
    {
        $promo->is_active = !$promo->is_active; // Membalik nilai is_active
        $promo->save();

        return response()->json(['success' => true, 'is_active' => $promo->is_active]);
    }
}