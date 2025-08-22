<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            'category_id' => 1, // Makanan Ringan
            'name' => 'Keripik Kentang',
            'sku' => 'PRD-001',
            'price' => 15000,
            'stock' => 100,
        ]);

        Product::create([
            'category_id' => 2, // Minuman Dingin
            'name' => 'Teh Botol',
            'sku' => 'PRD-002',
            'price' => 5000,
            'stock' => 250,
        ]);

        Product::create([
            'category_id' => 2, // Minuman Dingin
            'name' => 'Air Mineral 600ml',
            'sku' => 'PRD-003',
            'price' => 3500,
            'stock' => 300,
        ]);

        Product::create([
            'category_id' => 3, // Kebutuhan Dapur
            'name' => 'Minyak Goreng 1L',
            'sku' => 'PRD-004',
            'price' => 25000,
            'stock' => 50,
        ]);
    }
}