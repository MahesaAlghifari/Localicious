<?php

namespace App\Filament\Resources\GeofencingNotificationResource\Pages;

use App\Filament\Resources\GeofencingNotificationResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListGeofencingNotifications extends ListRecords
{
    protected static string $resource = GeofencingNotificationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
