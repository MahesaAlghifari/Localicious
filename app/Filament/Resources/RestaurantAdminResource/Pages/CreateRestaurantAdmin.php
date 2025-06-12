<?php

namespace App\Filament\Resources\RestaurantAdminResource\Pages;

use App\Filament\Resources\RestaurantAdminResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateRestaurantAdmin extends CreateRecord
{
    protected static string $resource = RestaurantAdminResource::class;
}
