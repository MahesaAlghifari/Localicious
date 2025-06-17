<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    /**
     * Kolom yang dapat diisi secara massal.
     */
    protected $fillable = [
        'order_id',     // bisa null jika belum checkout
        'menu_id',
        'quantity',
        'unit_price',
        'subtotal',
    ];

    /**
     * Konversi atribut otomatis ke tipe data yang sesuai.
     */
    protected $casts = [
        'quantity'    => 'integer',
        'unit_price'  => 'float',
        'subtotal'    => 'float',
    ];

    // =========================================================================
    // 🔗 RELATIONSHIPS
    // =========================================================================

    /**
     * Item ini termasuk dalam satu order.
     * Bisa null saat item masih dalam keranjang.
     */
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    /**
     * Item ini merepresentasikan satu menu.
     */
    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    // =========================================================================
    // 📐 ACCESSORS & SCOPES
    // =========================================================================

    /**
     * Akses atribut total secara dinamis jika subtotal belum disimpan.
     */
    public function getTotalAttribute(): float
    {
        return ($this->unit_price ?? 0) * ($this->quantity ?? 0);
    }

    /**
     * Scope untuk mengambil item yang belum dimasukkan ke dalam order.
     * Contoh: item dalam keranjang sebelum checkout.
     */
    public function scopeUnordered($query)
    {
        return $query->whereNull('order_id');
    }
}
