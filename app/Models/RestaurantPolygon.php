<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RestaurantPolygon extends Model
{
    use HasFactory;

    // Mass‐assign semua kolom
    protected $guarded = [];

    // Relasi ke Restaurant
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }
}
