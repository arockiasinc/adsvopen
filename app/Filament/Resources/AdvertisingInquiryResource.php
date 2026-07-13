<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AdvertisingInquiryResource\Pages;
use App\Models\AdvertisingInquiry;
use App\Support\AdQuotePreview;
use App\Support\AdTargeting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class AdvertisingInquiryResource extends Resource
{
    protected static ?string $model = AdvertisingInquiry::class;

    protected static ?string $navigationIcon = 'heroicon-o-megaphone';

    protected static ?string $navigationLabel = 'Advertising Requests';

    protected static ?string $modelLabel = 'advertising request';

    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        // Admins only manage the workflow status; answers are read-only.
        return $form
            ->schema([
                Forms\Components\Select::make('status')
                    ->options([
                        'New' => 'New',
                        'In Review' => 'In Review',
                        'Contacted' => 'Contacted',
                        'Won' => 'Won',
                        'Closed' => 'Closed',
                    ])
                    ->default('New')
                    ->required(),
            ]);
    }

    /**
     * The targeted places, one per line. Inquiries submitted before targeting
     * moved to province/region/city IDs still carry the old province + category
     * text, so fall back to that.
     *
     * @return array<int, string>
     */
    protected static function locationLines(AdvertisingInquiry $record): array
    {
        if (filled($record->target_scope)) {
            return $record->targetSummary();
        }

        $lines = [];

        foreach ((array) $record->target_regions as $province => $categories) {
            if (! is_array($categories)) {
                $lines[] = $province.': '.$categories;

                continue;
            }

            foreach ($categories as $category => $places) {
                $label = ucwords(str_replace('_', ' ', (string) $category));
                $placeList = is_array($places) ? implode(', ', $places) : $places;
                $lines[] = $province.' — '.$label.': '.$placeList;
            }
        }

        return $lines ?: array_map('strval', (array) $record->target_provinces);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Advertiser')
                    ->columns(3)
                    ->schema([
                        Infolists\Components\TextEntry::make('user.name')->label('Account'),
                        Infolists\Components\TextEntry::make('business_name'),
                        Infolists\Components\TextEntry::make('status')->badge(),
                        Infolists\Components\TextEntry::make('contact_name'),
                        Infolists\Components\TextEntry::make('contact_email'),
                        Infolists\Components\TextEntry::make('contact_phone')->placeholder('—'),
                    ]),
                Infolists\Components\Section::make('Business & targeting')
                    ->columns(2)
                    ->schema([
                        Infolists\Components\TextEntry::make('industry'),
                        Infolists\Components\TextEntry::make('business_province'),
                        Infolists\Components\TextEntry::make('company_size'),
                        Infolists\Components\TextEntry::make('duration'),
                        Infolists\Components\TextEntry::make('adType.name')
                            ->label('Ad type')
                            ->placeholder('—'),
                        Infolists\Components\TextEntry::make('target_scope')
                            ->label('Targeting scope')
                            ->formatStateUsing(fn (?string $state): string => AdTargeting::scopeLabel($state))
                            ->placeholder('—'),
                        Infolists\Components\TextEntry::make('targets')
                            ->label('Locations')
                            ->placeholder('—')
                            ->columnSpanFull()
                            ->listWithLineBreaks()
                            ->bulleted()
                            ->getStateUsing(fn (AdvertisingInquiry $record): array => self::locationLines($record)),
                    ]),
                Infolists\Components\Section::make('Rate card quote')
                    ->description('What our published rates come to for the ad type and locations above.')
                    ->visible(fn (AdvertisingInquiry $record): bool => filled($record->quote['lines'] ?? null)
                        || filled($record->quote['unpriced'] ?? null))
                    ->schema([
                        Infolists\Components\TextEntry::make('quote')
                            ->hiddenLabel()
                            ->html()
                            ->getStateUsing(fn (AdvertisingInquiry $record) => AdQuotePreview::toHtml($record->quote)),
                    ]),
                Infolists\Components\Section::make('Campaign details')
                    ->columns(2)
                    ->schema([
                        Infolists\Components\IconEntry::make('sells_on_vopen')->boolean(),
                        Infolists\Components\TextEntry::make('seller_id')->placeholder('—'),
                        Infolists\Components\IconEntry::make('wants_website_link')->boolean(),
                        Infolists\Components\TextEntry::make('website_link')->placeholder('—')->url(fn ($state) => $state),
                        Infolists\Components\TextEntry::make('ad_about'),
                        Infolists\Components\TextEntry::make('ad_about_other')->placeholder('—'),
                        Infolists\Components\TextEntry::make('display_schedule'),
                        Infolists\Components\TextEntry::make('daily_budget_band')->label('Daily budget'),
                        Infolists\Components\TextEntry::make('daily_budget_other')
                            ->formatStateUsing(fn ($state): string => is_numeric($state) ? '$'.number_format((float) $state, 2) : (string) $state)
                            ->placeholder('—'),
                        Infolists\Components\TextEntry::make('yearly_marketing_budget')
                            ->formatStateUsing(fn ($state): string => is_numeric($state) ? '$'.number_format((float) $state, 2) : (string) $state)
                            ->placeholder('—'),
                    ]),
                Infolists\Components\Section::make('Flags & creative')
                    ->columns(2)
                    ->schema([
                        Infolists\Components\IconEntry::make('advertising_apps')->boolean(),
                        Infolists\Components\IconEntry::make('special_promotion')->boolean(),
                        Infolists\Components\IconEntry::make('generic_social_message')->boolean(),
                        Infolists\Components\IconEntry::make('is_government_agency')->boolean(),
                        Infolists\Components\TextEntry::make('digital_file_path')
                            ->label('Uploaded file')
                            ->placeholder('—')
                            ->html()
                            ->formatStateUsing(function ($state): string {
                                if (blank($state)) {
                                    return '—';
                                }

                                $url = asset('storage/'.ltrim((string) $state, '/'));
                                $ext = strtolower(pathinfo((string) $state, PATHINFO_EXTENSION));

                                if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'], true)) {
                                    $preview = '<img src="'.e($url).'" alt="Uploaded file" class="rounded-lg" style="max-height:320px;max-width:100%;object-fit:contain">';
                                } elseif (in_array($ext, ['mp4', 'webm', 'ogg', 'mov'], true)) {
                                    $preview = '<video src="'.e($url).'" controls class="rounded-lg" style="max-height:320px;max-width:100%"></video>';
                                } elseif ($ext === 'pdf') {
                                    $preview = '<iframe src="'.e($url).'" class="rounded-lg w-full" style="height:480px;border:0"></iframe>';
                                } else {
                                    $preview = '';
                                }

                                return $preview
                                    .'<div class="mt-2"><a href="'.e($url).'" target="_blank" rel="noopener" '
                                    .'class="text-primary-600 underline">Open in new tab</a></div>';
                            })
                            ->columnSpanFull(),
                    ]),
                Infolists\Components\Section::make('Recommended options')
                    ->schema([
                        Infolists\Components\TextEntry::make('recommendations')
                            ->hiddenLabel()
                            ->badge()
                            ->placeholder('—'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('business_name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Account')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('adType.name')
                    ->label('Ad type')
                    ->searchable()
                    ->placeholder('—'),
                Tables\Columns\TextColumn::make('target_scope')
                    ->label('Targeting')
                    ->formatStateUsing(fn (?string $state): string => AdTargeting::scopeLabel($state))
                    ->placeholder('—')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('industry')
                    ->searchable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('company_size')
                    ->badge()
                    ->sortable(),
                Tables\Columns\TextColumn::make('daily_budget_band')
                    ->label('Daily budget')
                    ->toggleable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Won' => 'success',
                        'Contacted', 'In Review' => 'info',
                        'Closed' => 'gray',
                        default => 'warning',
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'New' => 'New',
                        'In Review' => 'In Review',
                        'Contacted' => 'Contacted',
                        'Won' => 'Won',
                        'Closed' => 'Closed',
                    ]),
                Tables\Filters\SelectFilter::make('company_size')
                    ->options(config('advertising.company_sizes')),
                Tables\Filters\SelectFilter::make('ad_type_id')
                    ->label('Ad type')
                    ->options(fn (): array => \App\Models\AdType::options()),
                Tables\Filters\SelectFilter::make('target_scope')
                    ->label('Targeting')
                    ->options(AdTargeting::scopeOptions()),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make()->label('Status'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('No advertising requests yet');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAdvertisingInquiries::route('/'),
            'view' => Pages\ViewAdvertisingInquiry::route('/{record}'),
            'edit' => Pages\EditAdvertisingInquiry::route('/{record}/edit'),
        ];
    }
}
