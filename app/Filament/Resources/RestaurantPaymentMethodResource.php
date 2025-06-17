<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RestaurantPaymentMethodResource\Pages;
use App\Models\RestaurantPaymentMethod;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Actions\Action;

class RestaurantPaymentMethodResource extends Resource
{
    protected static ?string $model = RestaurantPaymentMethod::class;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';
    protected static ?string $navigationLabel = 'Restaurant Payment Methods';
    protected static ?string $navigationGroup = 'Konfigurasi';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('restaurant_id')
                ->label('Restaurant')
                ->relationship('restaurant', 'name')
                ->preload()
                ->searchable()
                ->required()
                ->reactive(),

            Repeater::make('payment_methods')
                ->label('Payment Methods')
                ->schema([
                    Select::make('payment_method_id')
                        ->label('Payment Method')
                        ->relationship('paymentMethod', 'name')
                        ->preload()
                        ->searchable()
                        ->required(),
                ])
                ->defaultItems(1)
                ->minItems(1)
                ->createItemButtonLabel('Tambah Payment Method')
                ->columns(1),

        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('restaurant.name')
                    ->label('Restaurant')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('paymentMethod.name')
                    ->label('Payment Method')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Updated At')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRestaurantPaymentMethods::route('/'),
            'create' => Pages\CreateRestaurantPaymentMethod::route('/create'),
            'edit' => Pages\EditRestaurantPaymentMethod::route('/{record}/edit'),
        ];
    }
}
