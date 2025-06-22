<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestaurantPolygon extends Model
{
    use HasFactory;

    // Mass-assign semua kolom
    protected $guarded = [];

    // Pastikan kolom coordinates otomatis dikonversi menjadi array saat diakses
    protected $casts = [
        'coordinates' => 'array',
    ];

    /**
     * Relasi ke model Restaurant
     */
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    /**
     * Accessor tambahan opsional (tidak wajib)
     * Untuk menampilkan koordinat dalam format HTML (jika dibutuhkan di panel admin)
     */
    public function getCoordinatesHtmlAttribute(): string
    {
        if (!is_array($this->coordinates)) {
            return '';
        }

        return collect($this->coordinates)
            ->map(fn($c) => '[' . implode(', ', $c) . ']')
            ->implode('<br>');
    }
    public function getFlattenedCoordinatesAttribute()
    {
        return $this->coordinates[0] ?? [];
    }
}
