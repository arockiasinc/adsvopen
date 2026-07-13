<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * Load the Canadian provinces, regions and cities advertisers target.
 *
 * The dataset in database/seeders/data/canada_locations.php is exported from the
 * marketplace, keeping its IDs, so advertisers target exactly the places
 * customers register against. Re-running the seeder updates names in place and
 * never renumbers anything, so rate-card rows keep pointing at the same places.
 */
class LocationSeeder extends Seeder
{
    public function run(): void
    {
        $data = require database_path('seeders/data/canada_locations.php');
        $now = now();

        $stamp = fn (array $rows): array => array_map(
            fn (array $row): array => $row + ['is_active' => true, 'created_at' => $now, 'updated_at' => $now],
            $rows,
        );

        DB::table('provinces')->upsert(
            $stamp($data['provinces']),
            ['id'],
            ['name', 'updated_at'],
        );

        foreach (array_chunk($data['regions'], 500) as $chunk) {
            DB::table('regions')->upsert($stamp($chunk), ['id'], ['province_id', 'name', 'updated_at']);
        }

        foreach (array_chunk($data['cities'], 500) as $chunk) {
            DB::table('cities')->upsert($stamp($chunk), ['id'], ['province_id', 'region_id', 'name', 'updated_at']);
        }

        $this->command?->info(sprintf(
            'Locations seeded: %d provinces, %d regions, %d cities.',
            count($data['provinces']),
            count($data['regions']),
            count($data['cities']),
        ));
    }
}
