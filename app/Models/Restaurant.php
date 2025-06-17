<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    use HasFactory;

    // Otomatis load relasi 'menus' setiap kali query Restaurant
    protected $with = ['menus'];

    // Mass-assign semua kolom
    protected $guarded = [];

    // Relasi ke tabel menu
    public function menus()
    {
        return $this->hasMany(Menu::class);
    }

    // Accessor untuk memastikan image_url selalu berupa URL lengkap
    public function getImageUrlAttribute($value)
    {
        if (!$value) return '';

        if (str_starts_with($value, 'http')) {
            return $value;
        }

        if (!str_contains($value, '/')) {
            $value = 'images/' . $value;
        }

        return url('storage/' . ltrim($value, '/'));
    }
    public function paymentMethods()
    {
        return $this->belongsToMany(PaymentMethod::class);
    }
}
