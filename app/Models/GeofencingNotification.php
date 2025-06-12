<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeofencingNotification extends Model
{
    use HasFactory;

    // Mass‐assign semua kolom
    protected $guarded = [];

    // Relasi ke Restaurant
    public function restaurant()
    {
        return $this->belongsTo(Restaurant::class);
    }

    // Relasi ke Customer (opsional)
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // Relasi ke Polygon (opsional)
    public function polygon()
    {
        return $this->belongsTo(RestaurantPolygon::class, 'polygon_id');
    }
}
