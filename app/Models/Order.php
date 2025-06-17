<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    /**
     * Kolom yang dapat diisi secara massal
     */
    protected $fillable = [
        'user_id',
        'restaurant_id',
        'total_amount',
        'status',
        'scheduled_at',
        'payment_method',
        'notes',
        'midtrans_order_id',
    ];

    /**
     * Konversi tipe data otomatis
     */
    protected $casts = [
        'scheduled_at' => 'datetime',
        'total_amount' => 'float',
    ];

    // =========================================================================
    // 🔗 RELATIONSHIPS
    // =========================================================================

    /**
     * Order milik satu user (customer)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Order milik satu restoran
     */
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    /**
     * Order memiliki banyak item
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Order memiliki satu pembayaran
     */
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    // =========================================================================
    // 🔍 SCOPES
    // =========================================================================

    /**
     * Scope berdasarkan status
     */
    public function scopeStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope untuk order yang sudah dibayar
     */
    public function scopePaid($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope berdasarkan user
     */
    public function scopeByUser($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    // =========================================================================
    // 🔢 LOGIKA & HELPER
    // =========================================================================

    /**
     * Hitung ulang total dari semua subtotal order item
     */
    public function recalculateTotal(): void
    {
        $total = $this->items()->sum('subtotal');
        $this->update(['total_amount' => $total]);
    }

    /**
     * Label status untuk frontend (opsional)
     */
    public function getStatusLabelAttribute(): string
    {
        return ucfirst($this->status);
    }
}
