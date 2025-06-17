<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RestaurantPolygonResource\Pages;
use App\Models\RestaurantPolygon;
use App\Models\Restaurant;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\ViewColumn;

class RestaurantPolygonResource extends Resource
{
    protected static ?string $model = RestaurantPolygon::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('restaurant_id')
                    ->label('Restaurant')
                    ->options(function () {
                        $used = \App\Models\RestaurantPolygon::pluck('restaurant_id')->toArray();
                        return \App\Models\Restaurant::whereNotIn('id', $used)->pluck('name', 'id');
                    })
                    ->searchable()
                    ->required(),

                Forms\Components\ViewField::make('coordinates')
                    ->view('admin.partials.polygon_map')
                    ->columnSpanFull()
                    ->required()
            ]);
    }


    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('restaurant.name')
                    ->label('Restaurant')
                    ->sortable()
                    ->searchable(),
                // Tables\Columns\TextColumn::make('name')
                //     ->searchable(),
                Tables\Columns\TextColumn::make('coordinates')
                    ->label('Coordinates')
                    ->limit(100) // biar tidak terlalu panjang

                    ->copyable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                // ViewColumn::make('coordinates')
                //     ->label('Area')
                //     ->view('admin.partials.polygon_map_preview'),
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
            'index' => Pages\ListRestaurantPolygons::route('/'),
            'create' => Pages\CreateRestaurantPolygon::route('/create'),
            'edit' => Pages\EditRestaurantPolygon::route('/{record}/edit'),
        ];
    }
}
