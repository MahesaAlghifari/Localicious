<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\GeofenceLog;
use Illuminate\Http\Request;

class GeofenceLogController extends Controller
{
    // GET /api/geofence-logs
    public function index()
    {
        return GeofenceLog::with(['user', 'polygon'])->latest()->paginate();
    }

    // POST /api/geofence-logs
    public function store(Request $request)
    {
        $data = $request->validate([
            'user_id'       => 'required|exists:users,id',
            'polygon_id'    => 'required|exists:restaurant_polygons,id',
            'raw_lat'       => 'required|numeric',
            'raw_lng'       => 'required|numeric',
            'filt_lat'      => 'required|numeric',
            'filt_lng'      => 'required|numeric',
            'speed'         => 'required|numeric',
            'anomaly_count' => 'required|integer',
            'inside'        => 'required|boolean',
        ]);

        $log = GeofenceLog::create($data);
        return response()->json($log->load(['user','polygon']), 201);
    }

    // GET /api/geofence-logs/{id}
    public function show(GeofenceLog $geofenceLog)
    {
        return $geofenceLog->load(['user', 'polygon']);
    }

    // PUT /api/geofence-logs/{id}
    public function update(Request $request, GeofenceLog $geofenceLog)
    {
        $data = $request->validate([
            'raw_lat'       => 'numeric',
            'raw_lng'       => 'numeric',
            'filt_lat'      => 'numeric',
            'filt_lng'      => 'numeric',
            'speed'         => 'numeric',
            'anomaly_count' => 'integer',
            'inside'        => 'boolean',
        ]);

        $geofenceLog->update($data);
        return response()->json($geofenceLog->fresh(), 200);
    }

    // DELETE /api/geofence-logs/{id}
    public function destroy(GeofenceLog $geofenceLog)
    {
        $geofenceLog->delete();
        return response()->noContent();
    }
}
