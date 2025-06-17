<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Columns\Summarizers\Sum;

class OrderResource extends Resource
{
    /* -----------------------------------------------------------------------
     | Config
     |----------------------------------------------------------------------- */
    protected static ?string $model            = Order::class;
    protected static ?string $navigationIcon   = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationLabel  = 'Orders';
    protected static ?string $navigationGroup  = 'Transaksi';
    protected static ?int    $navigationSort   = 1;

    /* -----------------------------------------------------------------------
     | Form
     |----------------------------------------------------------------------- */
    public static function form(Form $form): Form
    {
        return $form->schema([
            /* ---- Customer & Restaurant ----------------------------------- */
            Forms\Components\Section::make('Customer & Restaurant')
                ->schema([
                    Forms\Components\Select::make('user_id')
                        ->relationship('user', 'name')
                        ->searchable()
                        ->required()
                        ->label('Customer'),

                    Forms\Components\Select::make('restaurant_id')
                        ->relationship('restaurant', 'name')
                        ->searchable()
                        ->required()
                        ->label('Restaurant'),
                ])
                ->columns(2),

            /* ---- Order Info ---------------------------------------------- */
            Forms\Components\Section::make('Order Info')
                ->schema([
                    Forms\Components\Select::make('status')
                        ->options([
                            'pending'    => 'Pending',
                            'processing' => 'Processing',
                            'completed'  => 'Completed',
                            'cancelled'  => 'Cancelled',
                        ])
                        ->native(false)
                        ->required()
                        ->label('Status'),

                    Forms\Components\TextInput::make('total_amount')
                        ->numeric()
                        ->prefix('Rp')
                        ->disabled()
                        ->dehydrated(false)
                        ->label('Total (Auto)'),

                    Forms\Components\DateTimePicker::make('scheduled_at')
                        ->label('Scheduled At'),

                    Forms\Components\TextInput::make('payment_method')
                        ->label('Payment Method'),

                    Forms\Components\Textarea::make('notes')
                        ->rows(3)
                        ->columnSpanFull(),
                ])
                ->columns(2),
        ]);
    }

    /* -----------------------------------------------------------------------
     | Table
     |----------------------------------------------------------------------- */
    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                /* -- Basic -------------------------------------------------- */
                Tables\Columns\TextColumn::make('id')
                    ->label('ID')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('user.name')
                    ->label('Customer')
                    ->searchable()
                    ->wrap(),

                Tables\Columns\TextColumn::make('restaurant.name')
                    ->label('Restaurant')
                    ->searchable()
                    ->wrap(),

                /* -- Status badge ------------------------------------------ */
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->label('Status')
                    ->color(fn (string $state) => match ($state) {
                        'pending'    => 'gray',
                        'processing' => 'warning',
                        'completed'  => 'success',
                        'cancelled'  => 'danger',
                    }),

                /* -- Money -------------------------------------------------- */
                Tables\Columns\TextColumn::make('total_amount')
                    ->label('Total')
                    ->money('IDR', locale: 'id')
                    ->alignRight()
                    ->sortable()
                    ->summarize(
                        Sum::make()
                            ->label('Grand Total')
                            ->money('IDR', locale: 'id')
                    ),

                Tables\Columns\TextColumn::make('payment_method')
                    ->label('Pay.')
                    ->formatStateUsing(fn (?string $state) => $state ? ucfirst(str_replace('_', ' ', $state)) : '-')
                    ->toggleable(isToggledHiddenByDefault: true),

                /* -- Dates -------------------------------------------------- */
                Tables\Columns\TextColumn::make('scheduled_at')
                    ->label('Scheduled')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Updated')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')

            /* ---------------- Filters ------------------------------------ */
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'pending'    => 'Pending',
                        'processing' => 'Processing',
                        'completed'  => 'Completed',
                        'cancelled'  => 'Cancelled',
                    ]),
                SelectFilter::make('restaurant_id')
                    ->relationship('restaurant', 'name')
                    ->label('Restaurant'),
            ])

            /* ---------------- Row / Bulk Actions ------------------------- */
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])

            ->searchable();
    }

    /* -----------------------------------------------------------------------
     | Relations (RelationManagers bisa didefinisikan di sini)
     |----------------------------------------------------------------------- */
    public static function getRelations(): array
    {
        // Contoh: tampilkan daftar order items di halaman View / Edit
        // return [ OrderItemsRelationManager::class ];
        return [];
    }

    /* -----------------------------------------------------------------------
     | Pages
     |----------------------------------------------------------------------- */
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            // 'view'  => Pages\ViewOrder::route('/{record}'), // aktifkan kalau ViewPage dibuat
            // 'edit'  => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
