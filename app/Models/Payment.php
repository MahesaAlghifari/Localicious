<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'payment_method_id',
        'transaction_id',
        'payment_type',
        'transaction_status',
        'fraud_status',
        'amount',
        'bank',
        'va_number',
        'payload', // untuk menyimpan JSON dari Midtrans
    ];

    protected $casts = [
        'payload' => 'array',
        'amount'  => 'float',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class);
    }
}
