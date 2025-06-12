<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class Customer extends Authenticatable
{
    use HasApiTokens, HasFactory;

    // Mass-assign semua kolom
    protected $guarded = [];

    // Jika butuh relasi di masa depan
    // public function orders() { ... }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
