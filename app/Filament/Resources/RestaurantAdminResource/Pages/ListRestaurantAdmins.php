<?php

namespace App\Filament\Resources\RestaurantAdminResource\Pages;

use App\Filament\Resources\RestaurantAdminResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRestaurantAdmins extends ListRecords
{
    protected static string $resource = RestaurantAdminResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
