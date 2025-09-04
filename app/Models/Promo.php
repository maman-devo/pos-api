<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

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
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
    ];

    // Accessor untuk mendapatkan status validitas promo
    public function getIsValidAttribute()
    {
        // Periksa apakah promo diaktifkan secara manual
        if (!$this->is_active) {
            return false;
        }

        $now = Carbon::now();

        // Periksa apakah tanggal saat ini berada di dalam periode promo
        if ($this->start_date && $this->end_date) {
            return $now->between($this->start_date, $this->end_date);
        }

        return true;
    }

    /**
     * Mendapatkan produk yang memiliki promo ini.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}