<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RestaurantResource\Pages;
use App\Models\Restaurant;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class RestaurantResource extends Resource
{
    protected static ?string $model = Restaurant::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('name')->required()->maxLength(255),
            Forms\Components\TextInput::make('address')->required()->maxLength(255),
            Forms\Components\TextInput::make('province')->required()->maxLength(255),
            Forms\Components\TextInput::make('city')->required()->maxLength(255),

            Forms\Components\Section::make('Jam Operasional')->schema([
                Forms\Components\TimePicker::make('mon_open')->label('Senin Buka')->seconds(false),
                Forms\Components\TimePicker::make('mon_close')->label('Senin Tutup')->seconds(false),
                Forms\Components\TimePicker::make('tue_open')->label('Selasa Buka')->seconds(false),
                Forms\Components\TimePicker::make('tue_close')->label('Selasa Tutup')->seconds(false),
                Forms\Components\TimePicker::make('wed_open')->label('Rabu Buka')->seconds(false),
                Forms\Components\TimePicker::make('wed_close')->label('Rabu Tutup')->seconds(false),
                Forms\Components\TimePicker::make('thu_open')->label('Kamis Buka')->seconds(false),
                Forms\Components\TimePicker::make('thu_close')->label('Kamis Tutup')->seconds(false),
                Forms\Components\TimePicker::make('fri_open')->label('Jumat Buka')->seconds(false),
                Forms\Components\TimePicker::make('fri_close')->label('Jumat Tutup')->seconds(false),
                Forms\Components\TimePicker::make('sat_open')->label('Sabtu Buka')->seconds(false),
                Forms\Components\TimePicker::make('sat_close')->label('Sabtu Tutup')->seconds(false),
                Forms\Components\TimePicker::make('sun_open')->label('Minggu Buka')->seconds(false),
                Forms\Components\TimePicker::make('sun_close')->label('Minggu Tutup')->seconds(false),
            ])->columns(2),

            Forms\Components\FileUpload::make('image_url')
                ->label('Gambar')
                ->image()
                ->required()
                ->disk('public')
                ->directory('images')
                ->preserveFilenames()
                ->visibility('public'),
 

        ]);
    }

    public static function table(Table $table): Table
    {   
        return $table->columns([
            Tables\Columns\TextColumn::make('name')->searchable(),
            Tables\Columns\TextColumn::make('address')->searchable(),
            Tables\Columns\TextColumn::make('province')->searchable(),
            Tables\Columns\TextColumn::make('city')->searchable(),

            Tables\Columns\TextColumn::make('mon_open'),
            Tables\Columns\TextColumn::make('mon_close'),
            Tables\Columns\TextColumn::make('tue_open'),
            Tables\Columns\TextColumn::make('tue_close'),
            Tables\Columns\TextColumn::make('wed_open'),
            Tables\Columns\TextColumn::make('wed_close'),
            Tables\Columns\TextColumn::make('thu_open'),
            Tables\Columns\TextColumn::make('thu_close'),
            Tables\Columns\TextColumn::make('fri_open'),
            Tables\Columns\TextColumn::make('fri_close'),
            Tables\Columns\TextColumn::make('sat_open'),
            Tables\Columns\TextColumn::make('sat_close'),
            Tables\Columns\TextColumn::make('sun_open'),
            Tables\Columns\TextColumn::make('sun_close'),

            Tables\Columns\ImageColumn::make('image_url')
                ->label('Image')
                ->disk('public')
                ->visibility(visibility: 'public'),

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
                // Tambahkan filter jika perlu
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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRestaurants::route('/'),
            'create' => Pages\CreateRestaurant::route('/create'),
            'edit' => Pages\EditRestaurant::route('/{record}/edit'),
        ];
    }
}
