<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->string('label');
            $table->string('target');
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        $now = now();

        DB::table('menus')->insert([
            ['label' => 'Banner Ads', 'target' => '#placements', 'sort_order' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['label' => 'Home page display Ads', 'target' => '#importance', 'sort_order' => 2, 'created_at' => $now, 'updated_at' => $now],
            ['label' => 'Product Sponsored ads', 'target' => '#case-studies', 'sort_order' => 3, 'created_at' => $now, 'updated_at' => $now],
            ['label' => 'Contractor Listing Ads', 'target' => '#partner-support', 'sort_order' => 4, 'created_at' => $now, 'updated_at' => $now],
            ['label' => 'Contractor Display ads', 'target' => '#creative-support', 'sort_order' => 5, 'created_at' => $now, 'updated_at' => $now],
            ['label' => 'Start Advertising', 'target' => '#campaign-setup', 'sort_order' => 6, 'created_at' => $now, 'updated_at' => $now],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menus');
    }
};
