<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CampaignResource\Pages;
use App\Filament\Resources\CampaignResource\RelationManagers;
use App\Models\Campaign;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CampaignResource extends Resource
{
    protected static ?string $model = Campaign::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->required(),
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('status')
                    ->options(Campaign::statusOptions())
                    ->required()
                    ->default(Campaign::STATUS_DRAFT),
                Forms\Components\TextInput::make('format')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('objective')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('daily_budget')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\TextInput::make('headline')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('copy')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('cta')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('start_date')
                    ->label('From')
                    ->required(),
                Forms\Components\DatePicker::make('end_date')
                    ->label('To')
                    ->required()
                    ->afterOrEqual('start_date'),
                Forms\Components\TagsInput::make('placements')
                    ->placeholder('Add a placement')
                    ->columnSpanFull(),
                Forms\Components\KeyValue::make('metrics')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Advertiser')
                    ->sortable(),
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('format')
                    ->searchable(),
                Tables\Columns\TextColumn::make('objective')
                    ->searchable(),
                Tables\Columns\TextColumn::make('daily_budget')
                    ->formatStateUsing(fn ($state): string => is_numeric($state) ? '$'.number_format((float) $state, 2) : (string) $state)
                    ->sortable(),
                Tables\Columns\TextColumn::make('headline')
                    ->searchable(),
                Tables\Columns\TextColumn::make('cta')
                    ->searchable(),
                Tables\Columns\TextColumn::make('start_date')
                    ->label('From')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->label('To')
                    ->date()
                    ->sortable(),
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
            'index' => Pages\ListCampaigns::route('/'),
            'create' => Pages\CreateCampaign::route('/create'),
            'edit' => Pages\EditCampaign::route('/{record}/edit'),
        ];
    }
}
