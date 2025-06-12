<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\GeofencingNotification;
use Illuminate\Http\Request;

class GeofencingNotificationController extends Controller
{
    // GET /api/geofencing-notifications
    public function index()
    {
        $notes = GeofencingNotification::with(['restaurant', 'customer', 'polygon'])->get();
        return response()->json($notes, 200);
    }

    // GET /api/geofencing-notifications/{id}
    public function show(GeofencingNotification $geofencingNotification)
    {
        return response()->json(
            $geofencingNotification->load(['restaurant', 'customer', 'polygon']),
            200
        );
    }

    // POST /api/geofencing-notifications
    public function store(Request $request)
    {
        $data = $request->validate([
            'restaurant_id' => 'required|exists:restaurants,id',
            'customer_id'   => 'nullable|exists:customers,id',
            'polygon_id'    => 'nullable|exists:restaurant_polygons,id',
            'event_type'    => 'required|in:enter,exit,breach',
            'notified_at'   => 'nullable|date',
            'payload'       => 'nullable|json',
        ]);

        $note = GeofencingNotification::create($data);

        return response()->json(
            $note->load(['restaurant', 'customer', 'polygon']),
            201
        );
    }

    // PUT/PATCH /api/geofencing-notifications/{id}
    public function update(Request $request, GeofencingNotification $geofencingNotification)
    {
        $data = $request->validate([
            'restaurant_id' => 'sometimes|required|exists:restaurants,id',
            'customer_id'   => 'nullable|exists:customers,id',
            'polygon_id'    => 'nullable|exists:restaurant_polygons,id',
            'event_type'    => 'sometimes|required|in:enter,exit,breach',
            'notified_at'   => 'nullable|date',
            'payload'       => 'nullable|json',
        ]);

        $geofencingNotification->update($data);

        return response()->json(
            $geofencingNotification->load(['restaurant', 'customer', 'polygon']),
            200
        );
    }

    // DELETE /api/geofencing-notifications/{id}
    public function destroy(GeofencingNotification $geofencingNotification)
    {
        $geofencingNotification->delete();
        return response()->json(null, 204);
    }
}