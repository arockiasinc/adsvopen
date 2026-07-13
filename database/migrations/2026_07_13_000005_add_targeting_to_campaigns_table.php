<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Campaigns gain the same targeting as inquiries, plus the quote priced from
     * the rate card at the time the campaign was saved.
     */
    public function up(): void
    {
        Schema::table('campaigns', function (Blueprint $table) {
            $table->foreignId('ad_type_id')->nullable()->after('format')
                ->constrained('ad_types')->nullOnDelete();
            $table->string('target_scope')->nullable()->after('ad_type_id');
            $table->json('target_province_ids')->nullable()->after('target_scope');
            $table->json('target_region_ids')->nullable()->after('target_province_ids');
            $table->json('target_city_ids')->nullable()->after('target_region_ids');
            $table->decimal('quoted_price', 12, 2)->nullable()->after('target_city_ids');
            $table->json('quote')->nullable()->after('quoted_price');
        });
    }

    public function down(): void
    {
        Schema::table('campaigns', function (Blueprint $table) {
            $table->dropConstrainedForeignId('ad_type_id');
            $table->dropColumn([
                'target_scope',
                'target_province_ids',
                'target_region_ids',
                'target_city_ids',
                'quoted_price',
                'quote',
            ]);
        });
    }
};
