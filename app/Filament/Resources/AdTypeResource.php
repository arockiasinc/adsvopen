<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AdTypeResource\Pages;
use App\Models\AdType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AdTypeResource extends Resource
{
    protected static ?string $model = AdType::class;

    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';

    protected static ?string $navigationGroup = 'Ad Pricing';

    protected static ?string $navigationLabel = 'Ad Types';

    protected static ?string $modelLabel = 'ad type';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true)
                    ->helperText('Shown to advertisers when they choose an ad format.'),
                Forms\Components\Textarea::make('description')
                    ->rows(3)
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('sort_order')
                    ->numeric()
                    ->default(0)
                    ->helperText('Lower numbers appear first.'),
                Forms\Components\Toggle::make('is_active')
                    ->default(true)
                    ->helperText('Inactive types are hidden from advertisers.'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('description')
                    ->limit(60)
                    ->toggleable(),
                Tables\Columns\TextColumn::make('prices_count')
                    ->label('Prices set')
                    ->counts('prices')
                    ->badge()
                    ->color(fn (int $state): string => $state > 0 ? 'success' : 'danger'),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->sortable(),
                Tables\Columns\TextColumn::make('sort_order')
                    ->sortable(),
            ])
            ->defaultSort('sort_order')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')->label('Active'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('No ad types yet')
            ->emptyStateDescription('Add the ad formats you sell, then price each one per location.');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAdTypes::route('/'),
            'create' => Pages\CreateAdType::route('/create'),
            'edit' => Pages\EditAdType::route('/{record}/edit'),
        ];
    }
}
