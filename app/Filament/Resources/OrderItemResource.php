<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderItemResource\Pages;
use App\Models\OrderItem;
use App\Models\Menu;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\Summarizers\Sum;

class OrderItemResource extends Resource
{
    protected static ?string $model = OrderItem::class;
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel = 'Order Items';
    protected static ?string $navigationGroup = 'Transaksi';

    // =========================================================================
    // 📝 FORM
    // =========================================================================
    public static function form(Form $form): Form
    {
        return $form->schema([
            // 🔗 Order (optional)
            Forms\Components\Select::make('order_id')
                ->label('Order (Opsional)')
                ->relationship('order', 'id')
                ->searchable()
                ->preload(),

            // 🔗 Menu
            Forms\Components\Select::make('menu_id')
                ->label('Menu')
                ->relationship('menu', 'item_name')
                ->preload()
                ->searchable()
                ->required()
                ->reactive()
                ->afterStateUpdated(function ($state, callable $set, callable $get) {
                    $menu = Menu::find($state);
                    $price = $menu?->price ?? 0;
                    $quantity = $get('quantity') ?? 1;

                    $set('unit_price', $price);
                    $set('subtotal', $price * $quantity);
                }),

            // 🔢 Quantity
            Forms\Components\TextInput::make('quantity')
                ->label('Jumlah')
                ->numeric()
                ->default(1)
                ->required()
                ->reactive()
                ->afterStateUpdated(function ($state, callable $set, callable $get) {
                    $unitPrice = $get('unit_price') ?? 0;
                    $set('subtotal', $unitPrice * ($state ?: 0));
                }),

            // 💰 Unit Price (readonly)
            Forms\Components\TextInput::make('unit_price')
                ->label('Harga Satuan')
                ->numeric()
                ->disabled()
                ->dehydrated()
                ->prefix('Rp'),

            // 💰 Subtotal (readonly)
            Forms\Components\TextInput::make('subtotal')
                ->label('Subtotal')
                ->numeric()
                ->disabled()
                ->dehydrated()
                ->prefix('Rp'),
        ])->columns(2);
    }

    // =========================================================================
    // 📊 TABLE
    // =========================================================================
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order.id')
                    ->label('Order')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('menu.item_name')
                    ->label('Menu')
                    ->searchable(),

                Tables\Columns\TextColumn::make('quantity')
                    ->numeric()
                    ->sortable(),

                Tables\Columns\TextColumn::make('unit_price')
                    ->money('IDR', locale: 'id')
                    ->label('Harga'),

                Tables\Columns\TextColumn::make('subtotal')
                    ->money('IDR', locale: 'id')
                    ->label('Subtotal')
                    ->summarize(
                        Sum::make()
                            ->label('Total')
                            ->money('IDR', locale: 'id')
                    ),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])
            ->searchable();
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListOrderItems::route('/'),
            'create' => Pages\CreateOrderItem::route('/create'),
            'edit'   => Pages\EditOrderItem::route('/{record}/edit'),
        ];
    }
}
