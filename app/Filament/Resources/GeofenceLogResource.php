<?php

namespace App\Filament\Resources;

use App\Filament\Resources\GeofenceLogResource\Pages;
use App\Filament\Resources\GeofenceLogResource\RelationManagers;
use App\Models\GeofenceLog;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class GeofenceLogResource extends Resource
{
    protected static ?string $model = GeofenceLog::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                Forms\Components\Select::make('polygon_id')
                    ->relationship('polygon', 'name')
                    ->required(),
                Forms\Components\TextInput::make('raw_lat')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('raw_lng')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('filt_lat')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('filt_lng')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('speed')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('anomaly_count')
                    ->required()
                    ->numeric(),
                Forms\Components\Toggle::make('inside')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('polygon.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('raw_lat')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('raw_lng')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('filt_lat')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('filt_lng')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('speed')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('anomaly_count')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('inside')
                    ->boolean(),
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
            'index' => Pages\ListGeofenceLogs::route('/'),
            'create' => Pages\CreateGeofenceLog::route('/create'),
            'edit' => Pages\EditGeofenceLog::route('/{record}/edit'),
        ];
    }
}
