<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MidtransTransaction extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Relasi ke Payment
    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    // Relasi ke RestaurantPaymentAccount
    public function paymentAccount()
    {
        return $this->belongsTo(RestaurantPaymentAccount::class, 'payment_account_id');
    }
}
