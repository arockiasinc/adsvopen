<?php

namespace Database\Seeders;

use App\Models\AdType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * The ad formats we sell. Admins can add to these and price each one per
 * location; everything that used to hardcode a format list now reads this table.
 */
class AdTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            ['name' => 'Banner Ads', 'description' => 'High-visibility banner placements across the marketplace.'],
            ['name' => 'Home Page Display Ads', 'description' => 'Premium display units on the homepage hero and feed.'],
            ['name' => 'Product Sponsored Ads', 'description' => 'Promote individual products in relevant search and category results.'],
            ['name' => 'Contractor Listing Ads', 'description' => 'Priority placement within contractor and partner listings.'],
            ['name' => 'Contractor Display Ads', 'description' => 'Rich display creative targeted to contractor audiences.'],
            ['name' => 'Native Ads', 'description' => 'Editorial-style placements that blend into the content feed.'],
            ['name' => 'Shoppable Ads', 'description' => 'Interactive ads that let buyers act without leaving the page.'],
            ['name' => 'GIF Ads', 'description' => 'Lightweight animated creative for time-sensitive campaigns.'],
        ];

        foreach ($types as $index => $type) {
            AdType::updateOrCreate(
                ['slug' => Str::slug($type['name'])],
                $type + ['is_active' => true, 'sort_order' => $index + 1],
            );
        }

        $this->command?->info(count($types).' ad types seeded.');
    }
}
