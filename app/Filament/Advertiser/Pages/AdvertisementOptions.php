<?php

namespace App\Filament\Advertiser\Pages;

use App\Models\AdType;
use Filament\Pages\Page;

class AdvertisementOptions extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';

    protected static ?string $navigationLabel = 'Available Ad Options';

    protected static ?string $title = 'Available Advertisement Options';

    protected static ?int $navigationSort = 1;

    protected static string $view = 'filament.advertiser.pages.advertisement-options';

    public static function canAccess(): bool
    {
        return (bool) auth()->user()?->isApprovedAdvertiser();
    }

    /**
     * The ad formats the admin currently sells, with the cheapest published rate
     * for each so advertisers can see where pricing starts.
     *
     * @return array<int, array{name: string, description: string}>
     */
    public function getOptions(): array
    {
        return AdType::query()
            ->where('is_active', true)
            ->with(['prices' => fn ($query) => $query->where('is_active', true)])
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get()
            ->map(function (AdType $adType): array {
                $cheapest = $adType->prices->sortBy('price')->first();

                return [
                    'name' => $adType->name,
                    'description' => trim(
                        (string) $adType->description
                        .($cheapest ? ' From '.$cheapest->formattedPrice().'.' : '')
                    ),
                ];
            })
            ->all();
    }
}
