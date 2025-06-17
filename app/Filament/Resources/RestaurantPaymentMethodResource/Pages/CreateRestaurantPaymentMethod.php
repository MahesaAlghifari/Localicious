<?php

namespace App\Filament\Resources\RestaurantPaymentMethodResource\Pages;

use App\Filament\Resources\RestaurantPaymentMethodResource;
use App\Models\RestaurantPaymentMethod;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;

class CreateRestaurantPaymentMethod extends CreateRecord
{
    protected static string $resource = RestaurantPaymentMethodResource::class;

    public function create(bool $another = false): void
    {
        $data = $this->form->getState();

        foreach ($data['payment_methods'] as $item) {
            \App\Models\RestaurantPaymentMethod::updateOrCreate(
                [
                    'restaurant_id'     => $data['restaurant_id'],
                    'payment_method_id' => $item['payment_method_id'],
                ]
            );
        }

        \Filament\Notifications\Notification::make()
            ->title('Payment methods berhasil disimpan')
            ->success()
            ->send();

        $this->redirect(static::getResource()::getUrl('index'));
    }
}
