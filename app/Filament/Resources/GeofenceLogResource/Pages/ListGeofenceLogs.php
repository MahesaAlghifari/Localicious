<?php

namespace App\Filament\Resources\GeofenceLogResource\Pages;

use App\Filament\Resources\GeofenceLogResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGeofenceLogs extends ListRecords
{
    protected static string $resource = GeofenceLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
