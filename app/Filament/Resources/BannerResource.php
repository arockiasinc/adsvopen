<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BannerResource\Pages;
use App\Filament\Resources\BannerResource\RelationManagers;
use App\Models\Banner;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BannerResource extends Resource
{
    protected static ?string $model = Banner::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('copy')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('detail')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('footer')
                    ->columnSpanFull(),
                Forms\Components\TagsInput::make('highlights')
                    ->helperText('Press Enter after each highlight.')
                    ->columnSpanFull(),
                Forms\Components\Repeater::make('button_rows')
                    ->label('Button rows')
                    ->schema([
                        Forms\Components\TagsInput::make('buttons')
                            ->helperText('One row of buttons. Press Enter after each label.'),
                    ])
                    ->mutateRelationshipDataBeforeCreateUsing(fn (array $data) => $data)
                    ->afterStateHydrated(function (Forms\Components\Repeater $component, $state) {
                        if (is_array($state)) {
                            $component->state(collect($state)->map(fn ($row) => [
                                'buttons' => is_array($row) ? $row : [],
                            ])->all());
                        }
                    })
                    ->dehydrateStateUsing(fn ($state) => collect($state ?? [])
                        ->map(fn ($row) => $row['buttons'] ?? [])
                        ->filter()
                        ->values()
                        ->all())
                    ->columnSpanFull(),
                Forms\Components\FileUpload::make('image_path')
                    ->image()
                    ->disk('public')
                    ->directory('banners')
                    ->visibility('public')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('sort_order')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image_url')
                    ->label('Image')
                    ->height(56)
                    ->width(96)
                    ->extraImgAttributes(['class' => 'object-cover rounded'])
                    ->defaultImageUrl(asset('images/hero-scene.svg')),
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->wrap(),
                Tables\Columns\TextColumn::make('sort_order')
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
            'index' => Pages\ListBanners::route('/'),
            'create' => Pages\CreateBanner::route('/create'),
            'edit' => Pages\EditBanner::route('/{record}/edit'),
        ];
    }
}
