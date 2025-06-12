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

    public function menus()
    {
        return $this->hasMany(Menu::class);
    }

    // ... relasi lainnya ...
}
