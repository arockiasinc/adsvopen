<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LegalPageResource\Pages;
use App\Models\LegalPage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class LegalPageResource extends Resource
{
    protected static ?string $model = LegalPage::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static ?string $navigationLabel = 'Legal Pages';

    protected static ?string $modelLabel = 'legal page';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (Forms\Set $set, ?string $state, string $operation): void {
                                if ($operation === 'create') {
                                    $set('slug', Str::slug((string) $state));
                                }
                            }),
                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->helperText('Public URL: /page/{slug}. Changing this breaks existing links.'),
                    ]),

                Forms\Components\RichEditor::make('content')
                    ->label('Page content')
                    ->required()
                    ->columnSpanFull()
                    ->toolbarButtons([
                        'bold', 'italic', 'underline', 'strike', 'link',
                        'h2', 'h3', 'bulletList', 'orderedList', 'blockquote',
                        'redo', 'undo',
                    ]),

                Forms\Components\Section::make('Visibility')
                    ->columns(3)
                    ->schema([
                        Forms\Components\Toggle::make('status')
                            ->label('Published')
                            ->default(true)
                            ->helperText('Unpublished pages return 404.'),
                        Forms\Components\Toggle::make('is_footer')
                            ->label('Show in footer')
                            ->default(true),
                        Forms\Components\TextInput::make('sort_order')
                            ->numeric()
                            ->default(0)
                            ->required()
                            ->helperText('Footer link order.'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('sort_order')
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable()
                    ->badge()
                    ->color('gray'),
                Tables\Columns\IconColumn::make('status')
                    ->label('Published')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_footer')
                    ->label('In footer')
                    ->boolean(),
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Order')
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->label('View')
                    ->icon('heroicon-m-arrow-top-right-on-square')
                    ->url(fn (LegalPage $record): string => route('legal.page', $record->slug))
                    ->openUrlInNewTab(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLegalPages::route('/'),
            'create' => Pages\CreateLegalPage::route('/create'),
            'edit' => Pages\EditLegalPage::route('/{record}/edit'),
        ];
    }
}
