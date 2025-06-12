<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GeofenceLog extends Model
{
    protected $fillable = [
        'user_id',
        'polygon_id',
        'raw_lat',
        'raw_lng',
        'filt_lat',
        'filt_lng',
        'speed',
        'anomaly_count',
        'inside',
    ];

    // Relasi ke User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke RestaurantPolygon
    public function polygon(): BelongsTo
    {
        return $this->belongsTo(RestaurantPolygon::class, 'polygon_id');
    }
}
