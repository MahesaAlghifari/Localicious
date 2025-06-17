<?php

namespace App\Filament\Resources\RestaurantPaymentMethodResource\Pages;

use App\Filament\Resources\RestaurantPaymentMethodResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRestaurantPaymentMethod extends EditRecord
{
    protected static string $resource = RestaurantPaymentMethodResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
