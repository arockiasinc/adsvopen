<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Targeting moves from free-text province/category names to province, region
     * and city IDs plus an explicit scope. The old `target_provinces` /
     * `target_regions` columns stay so existing inquiries still render.
     */
    public function up(): void
    {
        Schema::table('advertising_inquiries', function (Blueprint $table) {
            $table->foreignId('ad_type_id')->nullable()->after('company_size')
                ->constrained('ad_types')->nullOnDelete();
            $table->string('target_scope')->nullable()->after('ad_type_id');
            $table->json('target_province_ids')->nullable()->after('target_scope');
            $table->json('target_region_ids')->nullable()->after('target_province_ids');
            $table->json('target_city_ids')->nullable()->after('target_region_ids');
            $table->json('quote')->nullable()->after('target_city_ids');
        });
    }

    public function down(): void
    {
        Schema::table('advertising_inquiries', function (Blueprint $table) {
            $table->dropConstrainedForeignId('ad_type_id');
            $table->dropColumn([
                'target_scope',
                'target_province_ids',
                'target_region_ids',
                'target_city_ids',
                'quote',
            ]);
        });
    }
};
