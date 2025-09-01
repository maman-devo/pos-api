<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'product_id',
        'type',
        'value',
        'start_date',
        'end_date',
        'is_active',
    ];

    /**
     * Mendapatkan produk yang memiliki promo ini.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}