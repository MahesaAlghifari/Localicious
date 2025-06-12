<?php

namespace App\Filament\Resources\RestaurantPolygonResource\Pages;

use App\Filament\Resources\RestaurantPolygonResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRestaurantPolygons extends ListRecords
{
    protected static string $resource = RestaurantPolygonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
