<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    /**
     * Atribut yang dapat diisi secara massal (mass assignable).
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'transaction_code',
        'total_amount',
        'payment_method',
        'paid_amount',
        'change_amount',
    ];

    /**
     * Mendefinisikan relasi many-to-one ke model User.
     * Satu transaksi hanya dilakukan oleh satu user (kasir).
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Mendefinisikan relasi one-to-many ke model TransactionDetail.
     * Satu transaksi bisa memiliki banyak detail (item produk).
     */
    public function details()
    {
        return $this->hasMany(TransactionDetail::class);
    }
}