<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MenuResource\Pages;
use App\Models\Menu;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;

class MenuResource extends Resource
{
    protected static ?string $model            = Menu::class;
    protected static ?string $navigationIcon   = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel  = 'Menus';
    protected static ?string $navigationGroup  = 'Master Data';
    protected static ?int    $navigationSort   = 2;

    /* --------------------------------------------------------------------- */
    /* FORM                                                                  */
    /* --------------------------------------------------------------------- */
    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Select::make('restaurant_id')
                ->relationship('restaurant', 'name')
                ->searchable()
                ->required()
                ->label('Restaurant'),

            Forms\Components\TextInput::make('item_name')
                ->label('Menu Name')
                ->required()
                ->maxLength(255),

            Forms\Components\Textarea::make('description')
                ->label('Description')
                ->rows(3),

            Forms\Components\TextInput::make('price')
                ->required()
                ->numeric()
                ->prefix('Rp')
                ->label('Price (IDR)'),

            Forms\Components\Select::make('size')
                ->label('Size')
                ->options([
                    'small'  => 'Small',
                    'medium' => 'Medium',
                    'large'  => 'Large',
                ])
                ->placeholder('—')
                ->searchable(),

            Forms\Components\Select::make('spice_level')
                ->label('Spice')
                ->options([
                    'low'    => 'Low',
                    'medium' => 'Medium',
                    'high'   => 'High',
                ])
                ->placeholder('—'),

            Forms\Components\Select::make('category')
                ->label('Category')
                ->options([
                    'appetizer' => 'Appetizer',
                    'main'      => 'Main',
                    'dessert'   => 'Dessert',
                    'drink'     => 'Drink',
                ])
                ->placeholder('—')
                ->searchable(),

            Forms\Components\TextInput::make('quantity')
                ->numeric()
                ->minValue(0)
                ->label('Stock')
                ->required(),

            Forms\Components\Toggle::make('is_active')
                ->label('Active')
                ->default(true),

            Forms\Components\FileUpload::make('image_url')
                ->label('Image')
                ->disk('public')
                ->directory('images')
                ->preserveFilenames()
                ->image()
                ->imagePreviewHeight('150')
                ->columnSpanFull(),
        ])->columns(2);
    }

    /* --------------------------------------------------------------------- */
    /* TABLE                                                                 */
    /* --------------------------------------------------------------------- */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image_url')
                    ->label('Image')
                    ->disk('public')
                    ->circular()
                    ->height(40)
                    ->width(40),

                Tables\Columns\TextColumn::make('item_name')
                    ->searchable()
                    ->label('Menu'),

                Tables\Columns\TextColumn::make('restaurant.name')
                    ->label('Restaurant')
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->searchable(),

                Tables\Columns\TextColumn::make('price')
                    ->label('Price')
                    ->money('IDR', locale: 'id')
                    ->sortable(),

                Tables\Columns\TextColumn::make('category')
                    ->label('Cat.')
                    ->badge()
                    ->colors([
                        'primary'  => 'appetizer',
                        'success'  => 'main',
                        'warning'  => 'dessert',
                        'info'     => 'drink',
                    ]),

                Tables\Columns\TextColumn::make('size')
                    ->label('Size')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('spice_level')
                    ->label('Spice')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->label('Active'),

                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime('d M Y')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('updated_at', 'desc')
            ->filters([
                SelectFilter::make('restaurant_id')
                    ->relationship('restaurant', 'name')
                    ->label('Restaurant'),

                SelectFilter::make('category')
                    ->options([
                        'appetizer' => 'Appetizer',
                        'main'      => 'Main',
                        'dessert'   => 'Dessert',
                        'drink'     => 'Drink',
                    ]),

                SelectFilter::make('is_active')
                    ->options([
                        true  => 'Active',
                        false => 'Inactive',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])
            ->searchable()
            ->striped();
    }

    /* --------------------------------------------------------------------- */
    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListMenus::route('/'),
            'create' => Pages\CreateMenu::route('/create'),
            'edit'   => Pages\EditMenu::route('/{record}/edit'),
        ];
    }
}
