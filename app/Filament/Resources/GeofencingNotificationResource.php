<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GeofencingNotificationResource\Pages;
use App\Filament\Resources\GeofencingNotificationResource\RelationManagers;
use App\Models\GeofencingNotification;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GeofencingNotificationResource extends Resource
{
    protected static ?string $model = GeofencingNotification::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('restaurant_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('customer_id')
                    ->numeric(),
                Forms\Components\TextInput::make('polygon_id')
                    ->numeric(),
                Forms\Components\TextInput::make('event_type')
                    ->required(),
                Forms\Components\DateTimePicker::make('notified_at'),
                Forms\Components\TextInput::make('payload'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('restaurant_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('customer_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('polygon_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('event_type'),
                Tables\Columns\TextColumn::make('notified_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListGeofencingNotifications::route('/'),
            'create' => Pages\CreateGeofencingNotification::route('/create'),
            'edit' => Pages\EditGeofencingNotification::route('/{record}/edit'),
        ];
    }
}
