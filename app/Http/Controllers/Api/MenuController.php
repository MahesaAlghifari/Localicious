<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MenuController extends Controller
{
    // GET /api/menus
    public function index(Request $request)
    {
        $perPage = min($request->get('per_page', 20), 100);

        $menus = Menu::with('restaurant')
            ->when($request->restaurant_id, fn ($q, $id) => $q->where('restaurant_id', $id))
            ->when($request->category, fn ($q, $cat) => $q->where('category', $cat))
            ->when($request->active,   fn ($q, $a)  => $q->where('is_active', (bool) $a))
            ->when($request->search,   fn ($q, $s)  => $q->where('item_name', 'like', "%{$s}%"))
            ->latest()
            ->paginate($perPage);

        return response()->json($menus, 200);
    }

    // GET /api/menus/{menu}
    public function show(Menu $menu)
    {
        return response()->json($menu->load('restaurant'), 200);
    }

    // POST /api/menus
    public function store(Request $request)
    {
        $data = $this->validateMenu($request);

        try {
            if ($request->hasFile('image')) {
                $data['image_url'] = $this->storeImage($request->file('image'));
            }

            $menu = Menu::create($data);

            return response()->json($menu->load('restaurant'), 201);
        } catch (\Throwable $e) {
            report($e);
            return response()->json(['error' => 'Failed to create menu'], 500);
        }
    }

    // PUT/PATCH /api/menus/{menu}
    public function update(Request $request, Menu $menu)
    {
        $data = $this->validateMenu($request, true);

        try {
            if ($request->hasFile('image')) {
                $this->deleteImageIfExists($menu->image_url);
                $data['image_url'] = $this->storeImage($request->file('image'));
            }

            $menu->update($data);

            return response()->json($menu->load('restaurant'), 200);
        } catch (\Throwable $e) {
            report($e);
            return response()->json(['error' => 'Failed to update menu'], 500);
        }
    }

    // DELETE /api/menus/{menu}
    public function destroy(Menu $menu)
    {
        $this->deleteImageIfExists($menu->image_url);
        $menu->delete();

        return response()->json(null, 204);
    }

    /* -------------------------------------------------------------- */
    /* Helpers                                                        */
    /* -------------------------------------------------------------- */

    private function validateMenu(Request $request, bool $isUpdate = false): array
    {
        $base = $isUpdate ? 'sometimes' : 'required';

        return $request->validate([
            'restaurant_id' => "$base|exists:restaurants,id",
            'item_name'     => "$base|string|max:255",
            'description'   => 'nullable|string',
            'price'         => "$base|numeric|min:0",
            'size'          => 'nullable|in:small,medium,large',
            'spice_level'   => 'nullable|in:low,medium,high',
            'category'      => 'nullable|in:appetizer,main,dessert,drink',
            'quantity'      => "$base|integer|min:0",
            'is_active'     => 'sometimes|boolean',
            'image'         => 'nullable|image|max:2048',
        ]);
    }

    private function storeImage($file): string
    {
        $path = $file->store('images', 'public');          // simpan di storage/app/public/images
        return url('storage/' . $path);                    // hasil: https://domain.com/storage/images/xyz.jpg
    }

    private function deleteImageIfExists(?string $url): void
    {
        if (!$url) return;

        // url('storage/images/xyz.jpg') -> images/xyz.jpg
        $relative = ltrim(str_replace(url('storage'), '', $url), '/');
        Storage::disk('public')->delete($relative);
    }
}
