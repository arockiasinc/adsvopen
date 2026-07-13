<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * The rate card: one row per (ad type x location) the admin wants to price.
     *
     * The location columns that matter depend on `scope`:
     *   country  -> all three null
     *   province -> province_id
     *   region   -> province_id + region_id
     *   city     -> province_id + city_id
     *
     * Lookups fall back from the most specific scope to the least, so an admin
     * can price a whole province once and override individual cities.
     */
    public function up(): void
    {
        Schema::create('ad_prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ad_type_id')->constrained('ad_types')->cascadeOnDelete();
            $table->string('scope');
            $table->foreignId('province_id')->nullable()->constrained('provinces')->cascadeOnDelete();
            $table->foreignId('region_id')->nullable()->constrained('regions')->cascadeOnDelete();
            $table->foreignId('city_id')->nullable()->constrained('cities')->cascadeOnDelete();
            $table->decimal('price', 10, 2);
            $table->string('unit')->default('month');
            $table->string('currency', 3)->default('CAD');
            $table->text('notes')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['ad_type_id', 'scope', 'is_active'], 'ad_prices_lookup_index');
            $table->index(['province_id', 'region_id', 'city_id'], 'ad_prices_location_index');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ad_prices');
    }
};
