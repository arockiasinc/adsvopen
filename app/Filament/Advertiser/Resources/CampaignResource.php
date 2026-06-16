<?php

namespace App\Filament\Advertiser\Resources;

use App\Filament\Advertiser\Resources\CampaignResource\Pages;
use App\Models\Campaign;
use Filament\Forms;
use Filament\Forms\Form;
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
                        Forms\Components\Select::make('format')
                            ->options([
                                'Banner Ads' => 'Banner Ads',
                                'Home Page Display Ads' => 'Home Page Display Ads',
                                'Product Sponsored Ads' => 'Product Sponsored Ads',
                                'Contractor Listing Ads' => 'Contractor Listing Ads',
                                'Contractor Display Ads' => 'Contractor Display Ads',
                                'Native Ads' => 'Native Ads',
                                'Shoppable Ads' => 'Shoppable Ads',
                                'GIF Ads' => 'GIF Ads',
                            ])
                            ->required(),
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
                            ->required(),
                        Forms\Components\DatePicker::make('end_date')
                            ->label('To')
                            ->required()
                            ->afterOrEqual('start_date'),
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
                        Infolists\Components\TextEntry::make('format'),
                        Infolists\Components\TextEntry::make('objective'),
                        Infolists\Components\TextEntry::make('daily_budget')
                            ->formatStateUsing(fn ($state): string => is_numeric($state) ? '$'.number_format((float) $state, 2) : (string) $state),
                        Infolists\Components\TextEntry::make('cta')->label('Call to action'),
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
                Tables\Columns\TextColumn::make('format')
                    ->searchable(),
                Tables\Columns\TextColumn::make('daily_budget')
                    ->formatStateUsing(fn ($state): string => is_numeric($state) ? '$'.number_format((float) $state, 2) : (string) $state)
                    ->sortable(),
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
