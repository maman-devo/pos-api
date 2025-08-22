<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    /**
     * Atribut yang dapat diisi secara massal (mass assignable).
     *
     * @var array<int, string>
     */
    protected $fillable = ['name'];

    /**
     * Mendefinisikan relasi one-to-many ke model Product.
     * Satu kategori bisa memiliki banyak produk.
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}