<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AdPriceResource\Pages;
use App\Models\AdPrice;
use App\Models\AdType;
use App\Support\AdTargeting;
use Closure;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AdPriceResource extends Resource
{
    protected static ?string $model = AdPrice::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    protected static ?string $navigationGroup = 'Ad Pricing';

    protected static ?string $navigationLabel = 'Rate Card';

    protected static ?string $modelLabel = 'price';

    protected static ?string $pluralModelLabel = 'rate card';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('What is being priced')
                    ->description('Prices fall back from the most specific location to the least: a city uses its own price, then its region\'s, then its province\'s, then the country-wide one. Set a country-wide price per ad type and you have covered everything.')
                    ->columns(2)
                    ->schema([
                        Forms\Components\Select::make('ad_type_id')
                            ->label('Ad type')
                            ->options(fn (): array => AdType::options())
                            ->searchable()
                            ->required()
                            ->live(),

                        Forms\Components\Select::make('scope')
                            ->label('Applies to')
                            ->options(AdTargeting::priceableScopeOptions())
                            ->required()
                            ->live()
                            ->afterStateUpdated(function (Forms\Set $set): void {
                                $set('province_id', null);
                                $set('region_id', null);
                                $set('city_id', null);
                            }),

                        Forms\Components\Select::make('province_id')
                            ->label('Province')
                            ->options(fn (): array => AdTargeting::provinceOptions())
                            ->searchable()
                            ->required(fn (Get $get): bool => self::needsProvince($get('scope')))
                            ->visible(fn (Get $get): bool => self::needsProvince($get('scope')))
                            ->live()
                            ->afterStateUpdated(function (Forms\Set $set): void {
                                $set('region_id', null);
                                $set('city_id', null);
                            }),

                        Forms\Components\Select::make('region_id')
                            ->label('Region')
                            ->options(fn (Get $get): array => AdTargeting::regionOptions($get('province_id')))
                            ->searchable()
                            ->required(fn (Get $get): bool => $get('scope') === AdTargeting::SCOPE_REGION)
                            ->visible(fn (Get $get): bool => $get('scope') === AdTargeting::SCOPE_REGION),

                        Forms\Components\Select::make('city_id')
                            ->label('City')
                            ->options(fn (Get $get): array => AdTargeting::cityOptions($get('province_id')))
                            ->searchable()
                            ->required(fn (Get $get): bool => $get('scope') === AdTargeting::SCOPE_CITY)
                            ->visible(fn (Get $get): bool => $get('scope') === AdTargeting::SCOPE_CITY),
                    ]),

                Forms\Components\Section::make('Price')
                    ->columns(3)
                    ->schema([
                        Forms\Components\TextInput::make('price')
                            ->label('Price')
                            ->numeric()
                            ->minValue(0)
                            ->prefix('$')
                            ->required()
                            ->rule(static function (Get $get, ?AdPrice $record): Closure {
                                return static function (string $attribute, $value, Closure $fail) use ($get, $record): void {
                                    $duplicate = AdPrice::query()
                                        ->where('ad_type_id', $get('ad_type_id'))
                                        ->where('scope', $get('scope'))
                                        ->where('province_id', $get('province_id') ?: null)
                                        ->where('region_id', $get('region_id') ?: null)
                                        ->where('city_id', $get('city_id') ?: null)
                                        ->when($record, fn ($query) => $query->whereKeyNot($record->getKey()))
                                        ->exists();

                                    if ($duplicate) {
                                        $fail('This ad type is already priced for that location. Edit the existing row instead.');
                                    }
                                };
                            }),

                        Forms\Components\Select::make('unit')
                            ->label('Charged')
                            ->options(AdPrice::unitOptions())
                            ->default(AdPrice::UNIT_MONTH)
                            ->required(),

                        Forms\Components\TextInput::make('currency')
                            ->default('CAD')
                            ->maxLength(3)
                            ->required(),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Active')
                            ->default(true)
                            ->helperText('Inactive prices are ignored when quoting.'),

                        Forms\Components\Textarea::make('notes')
                            ->rows(2)
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    protected static function needsProvince(?string $scope): bool
    {
        return in_array(
            $scope,
            [AdTargeting::SCOPE_PROVINCE, AdTargeting::SCOPE_REGION, AdTargeting::SCOPE_CITY],
            true,
        );
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn ($query) => $query->with(['adType', 'province', 'region', 'city']))
            ->columns([
                Tables\Columns\TextColumn::make('adType.name')
                    ->label('Ad type')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('scope')
                    ->label('Applies to')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => AdTargeting::priceableScopeOptions()[$state] ?? (string) $state)
                    ->color(fn (?string $state): string => match ($state) {
                        AdTargeting::SCOPE_COUNTRY => 'success',
                        AdTargeting::SCOPE_PROVINCE => 'info',
                        AdTargeting::SCOPE_REGION => 'warning',
                        default => 'gray',
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('location')
                    ->label('Location')
                    ->getStateUsing(fn (AdPrice $record): string => $record->locationLabel()),

                // Formatted by hand rather than with ->money(), which needs the
                // intl extension — not available on the XAMPP PHP this runs on.
                Tables\Columns\TextColumn::make('price')
                    ->formatStateUsing(fn ($state, AdPrice $record): string => $record->currency.' $'.number_format((float) $state, 2))
                    ->sortable(),

                Tables\Columns\TextColumn::make('unit')
                    ->label('Charged')
                    ->formatStateUsing(fn (?string $state): string => AdPrice::unitLabel($state))
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Active')
                    ->boolean()
                    ->sortable(),
            ])
            ->defaultSort('ad_type_id')
            ->filters([
                Tables\Filters\SelectFilter::make('ad_type_id')
                    ->label('Ad type')
                    ->options(fn (): array => AdType::options()),

                Tables\Filters\SelectFilter::make('scope')
                    ->label('Applies to')
                    ->options(AdTargeting::priceableScopeOptions()),

                Tables\Filters\SelectFilter::make('province_id')
                    ->label('Province')
                    ->options(fn (): array => AdTargeting::provinceOptions())
                    ->searchable(),

                Tables\Filters\TernaryFilter::make('is_active')->label('Active'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\ReplicateAction::make()
                    ->excludeAttributes(['created_at', 'updated_at'])
                    ->form(fn (Form $form): Form => static::form($form))
                    ->modalHeading('Copy this price to another location'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('No prices set yet')
            ->emptyStateDescription('Start with one country-wide price per ad type, then override individual provinces, regions or cities.');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAdPrices::route('/'),
            'create' => Pages\CreateAdPrice::route('/create'),
            'edit' => Pages\EditAdPrice::route('/{record}/edit'),
        ];
    }
}
