<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    /**
     * Kolom yang boleh diisi mass-assignment
     */
    protected $fillable = [
        'restaurant_id',
        'item_name',
        'description',
        'price',
        'size',
        'spice_level',
        'category',
        'quantity',
        'is_active',
        'image_url',
    ];

    /**
     * Casting tipe data
     */
    protected $casts = [
        'price'     => 'float',
        'quantity'  => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * Relasi ke restoran
     */
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    /**
     * Relasi ke item order (jika ada)
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Accessor agar image_url selalu URL lengkap
     */
    public function getImageUrlAttribute($value)
    {
        if (!$value) {
            return '';
        }

        // Sudah berbentuk URL
        if (str_starts_with($value, 'http')) {
            return $value;
        }

        // Jika hanya nama file (misalnya: "abc.jpg")
        if (!str_contains($value, '/')) {
            $value = 'images/' . $value;
        }

        return url('storage/' . ltrim($value, '/'));
    }

    /**
     * Scope: hanya menu aktif
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}

