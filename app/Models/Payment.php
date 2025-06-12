<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    // Mass‐assign semua kolom
    protected $guarded = [];

    // Relasi ke Order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Relasi ke MidtransTransactions (jika ada)
    public function midtransTransactions()
    {
        return $this->hasMany(MidtransTransaction::class);
    }
}
