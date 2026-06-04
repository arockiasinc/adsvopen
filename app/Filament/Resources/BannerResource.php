<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BannerResource\Pages;
use App\Models\Banner;
use Filament\Forms;
use Filament\Forms\Components\BaseFileUpload;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;

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
                    ->fetchFileInformation(false)
                    ->getUploadedFileUsing(function (BaseFileUpload $component, string $file, ?Banner $record): ?array {
                        if (! $record?->exists || $record->image_path !== $file) {
                            return null;
                        }

                        $fileExists = Storage::disk($component->getDiskName())->exists($file)
                            || Storage::disk('local')->exists($file)
                            || file_exists(public_path(ltrim($file, '/')));

                        if (! $fileExists) {
                            return null;
                        }

                        return [
                            'name' => basename($file),
                            'size' => 0,
                            'type' => null,
                            'url' => $record->image_url,
                        ];
                    })
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
                    // image_url is a root-relative path (e.g. /adsvopen/banners/1/image).
                    // Filament's ImageColumn only uses the state verbatim when it passes
                    // FILTER_VALIDATE_URL; otherwise it treats it as a storage path and
                    // falls back to the default image. Return an absolute URL so the real
                    // banner preview is rendered.
                    ->getStateUsing(function (Banner $record): ?string {
                        $url = (string) $record->image_url;

                        if ($url === '') {
                            return null;
                        }

                        if (\Illuminate\Support\Str::startsWith($url, ['http://', 'https://'])) {
                            return $url;
                        }

                        return request()->getSchemeAndHttpHost().'/'.ltrim($url, '/');
                    })
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
