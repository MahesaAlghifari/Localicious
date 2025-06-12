<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MidtransTransactionResource\Pages;
use App\Filament\Resources\MidtransTransactionResource\RelationManagers;
use App\Models\MidtransTransaction;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class MidtransTransactionResource extends Resource
{
    protected static ?string $model = MidtransTransaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('payment_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('payment_account_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('midtrans_order_id')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('transaction_id')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('va_number')
                    ->maxLength(255),
                Forms\Components\TextInput::make('payment_url')
                    ->maxLength(255),
                Forms\Components\Textarea::make('qr_string')
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('fraud_status')
                    ->maxLength(255),
                Forms\Components\TextInput::make('status_url')
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('payment_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('payment_account_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('midtrans_order_id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('transaction_id')
                    ->searchable(),
                Tables\Columns\TextColumn::make('va_number')
                    ->searchable(),
                Tables\Columns\TextColumn::make('payment_url')
                    ->searchable(),
                Tables\Columns\TextColumn::make('fraud_status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status_url')
                    ->searchable(),
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
            'index' => Pages\ListMidtransTransactions::route('/'),
            'create' => Pages\CreateMidtransTransaction::route('/create'),
            'edit' => Pages\EditMidtransTransaction::route('/{record}/edit'),
        ];
    }
}
