<?php

namespace App\Filament\Resources\RestaurantAdminResource\Pages;

use App\Filament\Resources\RestaurantAdminResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRestaurantAdmin extends EditRecord
{
    protected static string $resource = RestaurantAdminResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
