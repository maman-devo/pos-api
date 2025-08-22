<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Menampilkan daftar semua produk.
     */
    public function index()
    {
        // Ambil semua produk dengan relasi kategori
        $products = Product::with('category')->latest()->paginate(10);
        return response()->json($products);
    }

    /**
     * Menampilkan detail satu produk.
     */
    public function show(Product $product)
    {
        // Load relasi kategori
        $product->load('category');
        return response()->json($product);
    }
}