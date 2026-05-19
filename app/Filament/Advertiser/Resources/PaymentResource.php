<?php

namespace App\Filament\Advertiser\Resources;

use App\Filament\Advertiser\Resources\PaymentResource\Pages;
use App\Models\Payment;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class PaymentResource extends Resource
{
    protected static ?string $model = Payment::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static ?string $navigationLabel = 'Payment History';

    protected static ?string $modelLabel = 'payment';

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('user_id', auth()->id());
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('invoice_number')
                    ->label('Invoice')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('campaign_title')
                    ->label('Campaign')
                    ->searchable(),
                Tables\Columns\TextColumn::make('amount')
                    ->formatStateUsing(fn ($state): string => is_numeric($state) ? '$'.number_format((float) $state, 2) : (string) $state)
                    ->sortable(),
                Tables\Columns\TextColumn::make('issued_on')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => $state === 'Paid' ? 'success' : 'warning')
                    ->sortable(),
            ])
            ->defaultSort('issued_on', 'desc')
            ->actions([
                Tables\Actions\Action::make('receipt')
                    ->label('Download Receipt')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn (Payment $record): string => route('advertiser.receipt', $record))
                    ->openUrlInNewTab(),
            ])
            ->emptyStateHeading('No payments yet')
            ->emptyStateDescription('Your invoices and receipts will appear here.');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPayments::route('/'),
        ];
    }
}
