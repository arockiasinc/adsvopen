<?php

namespace App\Filament\Advertiser\Resources;

use App\Filament\Advertiser\Resources\CampaignResource\Pages;
use App\Models\AdType;
use App\Models\Campaign;
use App\Support\AdQuotePreview;
use App\Support\AdTargeting;
use App\Support\CampaignPricing;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class CampaignResource extends Resource
{
    protected static ?string $model = Campaign::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationLabel = 'My Ad Campaigns';

    protected static ?string $modelLabel = 'ad campaign';

    public static function canAccess(): bool
    {
        return (bool) auth()->user()?->isApprovedAdvertiser();
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('user_id', auth()->id());
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Campaign')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Select::make('status')
                            ->options(Campaign::statusOptions())
                            ->default(Campaign::STATUS_DRAFT)
                            ->helperText('Choose "Scheduled" to have the campaign go live automatically on the From date and end on the To date.')
                            ->required(),
                        Forms\Components\Select::make('ad_type_id')
                            ->label('Ad type')
                            ->options(fn (): array => AdType::options())
                            ->searchable()
                            ->required()
                            ->live(),
                        Forms\Components\TextInput::make('objective')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TextInput::make('daily_budget')
                            ->label('Daily budget')
                            ->numeric()
                            ->prefix('$')
                            ->default(0)
                            ->required(),
                    ]),
                Forms\Components\Section::make('Targeting')
                    ->description('Choose where this campaign runs. The price comes from our published rate card for that ad type and location.')
                    ->columns(2)
                    ->schema([
                        ...AdTargeting::formSchema(),
                        AdQuotePreview::field(fn (Get $get): ?int => CampaignPricing::daysBetween(
                            $get('start_date'),
                            $get('end_date'),
                        )),
                    ]),
                Forms\Components\Section::make('Creative')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('headline')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('copy')
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\TextInput::make('cta')
                            ->label('Call to action')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\TagsInput::make('placements')
                            ->placeholder('Add a placement')
                            ->columnSpanFull(),
                    ]),
                Forms\Components\Section::make('Schedule')
                    ->description('Set the date range the campaign should run.')
                    ->columns(2)
                    ->schema([
                        Forms\Components\DatePicker::make('start_date')
                            ->label('From')
                            ->required()
                            ->live(),
                        Forms\Components\DatePicker::make('end_date')
                            ->label('To')
                            ->required()
                            ->afterOrEqual('start_date')
                            ->live(),
                    ]),
            ]);
    }


    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Campaign')
                    ->columns(3)
                    ->schema([
                        Infolists\Components\TextEntry::make('title'),
                        Infolists\Components\TextEntry::make('status')->badge(),
                        Infolists\Components\TextEntry::make('adType.name')->label('Ad type')->placeholder('—'),
                        Infolists\Components\TextEntry::make('objective'),
                        Infolists\Components\TextEntry::make('daily_budget')
                            ->formatStateUsing(fn ($state): string => is_numeric($state) ? '$'.number_format((float) $state, 2) : (string) $state),
                        Infolists\Components\TextEntry::make('cta')->label('Call to action'),
                    ]),
                Infolists\Components\Section::make('Targeting & price')
                    ->columns(2)
                    ->schema([
                        Infolists\Components\TextEntry::make('target_scope')
                            ->label('Scope')
                            ->formatStateUsing(fn (?string $state): string => AdTargeting::scopeLabel($state))
                            ->placeholder('—'),
                        Infolists\Components\TextEntry::make('quoted_price')
                            ->label('Quoted price')
                            ->formatStateUsing(fn ($state): string => is_numeric($state) ? '$'.number_format((float) $state, 2) : '—')
                            ->helperText('Based on our rate card for this ad type, location and date range.')
                            ->placeholder('—'),
                        Infolists\Components\TextEntry::make('targets')
                            ->label('Locations')
                            ->getStateUsing(fn (Campaign $record): array => $record->targetSummary())
                            ->listWithLineBreaks()
                            ->bulleted()
                            ->placeholder('—')
                            ->columnSpanFull(),
                    ]),
                Infolists\Components\Section::make('Creative')
                    ->schema([
                        Infolists\Components\TextEntry::make('headline'),
                        Infolists\Components\TextEntry::make('copy'),
                        Infolists\Components\TextEntry::make('placements')->badge()->placeholder('—'),
                    ]),
                Infolists\Components\Section::make('Schedule')
                    ->columns(2)
                    ->schema([
                        Infolists\Components\TextEntry::make('start_date')->label('From')->date(),
                        Infolists\Components\TextEntry::make('end_date')->label('To')->date(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Active' => 'success',
                        'Scheduled' => 'info',
                        'Paused' => 'warning',
                        'Pending Review' => 'info',
                        'Ended' => 'danger',
                        default => 'gray',
                    })
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
                Tables\Columns\TextColumn::make('quoted_price')
                    ->label('Quoted price')
                    ->formatStateUsing(fn ($state): string => is_numeric($state) ? '$'.number_format((float) $state, 2) : '—')
                    ->sortable(),
                Tables\Columns\TextColumn::make('daily_budget')
                    ->formatStateUsing(fn ($state): string => is_numeric($state) ? '$'.number_format((float) $state, 2) : (string) $state)
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('start_date')
                    ->label('From')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->label('To')
                    ->date()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->emptyStateHeading('No ad campaigns yet')
            ->emptyStateDescription('Create your first ad campaign to get started.');
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCampaigns::route('/'),
            'create' => Pages\CreateCampaign::route('/create'),
            'view' => Pages\ViewCampaign::route('/{record}'),
            'edit' => Pages\EditCampaign::route('/{record}/edit'),
        ];
    }
}
