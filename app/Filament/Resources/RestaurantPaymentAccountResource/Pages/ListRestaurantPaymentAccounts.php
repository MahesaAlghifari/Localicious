<?php

namespace App\Filament\Resources\RestaurantPaymentAccountResource\Pages;

use App\Filament\Resources\RestaurantPaymentAccountResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRestaurantPaymentAccounts extends ListRecords
{
    protected static string $resource = RestaurantPaymentAccountResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
