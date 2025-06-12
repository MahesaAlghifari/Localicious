<?php

namespace App\Filament\Resources\GeofenceLogResource\Pages;

use App\Filament\Resources\GeofenceLogResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditGeofenceLog extends EditRecord
{
    protected static string $resource = GeofenceLogResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
