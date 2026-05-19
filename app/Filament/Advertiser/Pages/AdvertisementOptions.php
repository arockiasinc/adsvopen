<?php

namespace App\Filament\Advertiser\Pages;

use Filament\Pages\Page;

class AdvertisementOptions extends Page
{
    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';

    protected static ?string $navigationLabel = 'Available Ad Options';

    protected static ?string $title = 'Available Advertisement Options';

    protected static ?int $navigationSort = 1;

    protected static string $view = 'filament.advertiser.pages.advertisement-options';

    /**
     * @return array<int, array{name: string, description: string}>
     */
    public function getOptions(): array
    {
        return [
            ['name' => 'Banner Ads', 'description' => 'High-visibility banner placements across the marketplace.'],
            ['name' => 'Home Page Display Ads', 'description' => 'Premium display units on the homepage hero and feed.'],
            ['name' => 'Product Sponsored Ads', 'description' => 'Promote individual products in relevant search and category results.'],
            ['name' => 'Contractor Listing Ads', 'description' => 'Priority placement within contractor and partner listings.'],
            ['name' => 'Contractor Display Ads', 'description' => 'Rich display creative targeted to contractor audiences.'],
            ['name' => 'Native Ads', 'description' => 'Editorial-style placements that blend into the content feed.'],
            ['name' => 'Shoppable Ads', 'description' => 'Interactive ads that let buyers act without leaving the page.'],
            ['name' => 'GIF Ads', 'description' => 'Lightweight animated creative for time-sensitive campaigns.'],
        ];
    }
}
