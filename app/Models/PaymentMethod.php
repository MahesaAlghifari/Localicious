<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'name', 'is_active'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Relasi ke payments
     */
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Scope metode yang aktif
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function restaurants()
    {
        return $this->belongsToMany(Restaurant::class);
    }
}
