<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    // GET /api/notifications
    public function index()
    {
        // Tampilkan semua notifikasi beserta data restoran
        $notes = Notification::with('restaurant')->get();
        return response()->json($notes, 200);
    }

    // GET /api/notifications/{notification}
    public function show(Notification $notification)
    {
        return response()->json(
            $notification->load('restaurant'),
            200
        );
    }

    // POST /api/notifications
    public function store(Request $request)
    {
        $data = $request->validate([
            'restaurant_id' => 'required|exists:restaurants,id',
            'title'         => 'required|string|max:255',
            'message'       => 'required|string',
            'type'          => 'nullable|string|max:50',
            'is_read'       => 'sometimes|boolean',
        ]);

        $note = Notification::create($data);

        return response()->json(
            $note->load('restaurant'),
            201
        );
    }

    // PUT/PATCH /api/notifications/{notification}
    public function update(Request $request, Notification $notification)
    {
        $data = $request->validate([
            'restaurant_id' => 'sometimes|required|exists:restaurants,id',
            'title'         => 'sometimes|required|string|max:255',
            'message'       => 'sometimes|required|string',
            'type'          => 'nullable|string|max:50',
            'is_read'       => 'sometimes|boolean',
        ]);

        $notification->update($data);

        return response()->json(
            $notification->load('restaurant'),
            200
        );
    }

    // DELETE /api/notifications/{notification}
    public function destroy(Notification $notification)
    {
        $notification->delete();
        return response()->json(null, 204);
    }
}
