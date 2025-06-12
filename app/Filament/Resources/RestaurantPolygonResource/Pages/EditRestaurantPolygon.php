<?php

namespace App\Filament\Resources\RestaurantPolygonResource\Pages;

use App\Filament\Resources\RestaurantPolygonResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRestaurantPolygon extends EditRecord
{
    protected static string $resource = RestaurantPolygonResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
