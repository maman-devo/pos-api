<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /**
     * Atribut yang dapat diisi secara massal (mass assignable).
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'category_id',
        'name',
        'sku',
        'price',
        'stock',
        'image_url',
    ];

    /**
     * Mendefinisikan relasi many-to-one ke model Category.
     * Satu produk hanya memiliki satu kategori.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}