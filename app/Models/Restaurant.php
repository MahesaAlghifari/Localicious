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
    protected function formatTimeAttribute($value)
    {
        return $value ? \Carbon\Carbon::createFromFormat('H:i:s', $value)->format('H:i') : null;
    }
    public function getMonOpenAttribute($value)
    {
        return $this->formatTimeAttribute($value);
    }
    public function getMonCloseAttribute($value)
    {
        return $this->formatTimeAttribute($value);
    }
    public function getTueOpenAttribute($value)
    {
        return $this->formatTimeAttribute($value);
    }
    public function getTueCloseAttribute($value)
    {
        return $this->formatTimeAttribute($value);
    }
    public function getWedOpenAttribute($value)
    {
        return $this->formatTimeAttribute($value);
    }
    public function getWedCloseAttribute($value)
    {
        return $this->formatTimeAttribute($value);
    }
    public function getThuOpenAttribute($value)
    {
        return $this->formatTimeAttribute($value);
    }
    public function getThuCloseAttribute($value)
    {
        return $this->formatTimeAttribute($value);
    }
    public function getFriOpenAttribute($value)
    {
        return $this->formatTimeAttribute($value);
    }
    public function getFriCloseAttribute($value)
    {
        return $this->formatTimeAttribute($value);
    }
    public function getSatOpenAttribute($value)
    {
        return $this->formatTimeAttribute($value);
    }
    public function getSatCloseAttribute($value)
    {
        return $this->formatTimeAttribute($value);
    }
    public function getSunOpenAttribute($value)
    {
        return $this->formatTimeAttribute($value);
    }
    public function getSunCloseAttribute($value)
    {
        return $this->formatTimeAttribute($value);
    }
}
