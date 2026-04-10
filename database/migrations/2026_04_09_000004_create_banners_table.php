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
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('copy')->nullable();
            $table->text('detail')->nullable();
            $table->text('footer')->nullable();
            $table->json('highlights')->nullable();
            $table->json('button_rows')->nullable();
            $table->string('image_path');
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        $now = now();

        DB::table('banners')->insert([
            [
                'title' => 'Where you advertise matters.',
                'copy' => 'Be found where and when you need to be.',
                'detail' => 'We have it all covered, tailored to fit your goals.',
                'footer' => 'Canada\'s only platform to reach the right audience.',
                'highlights' => json_encode([
                    'Display Advertising',
                    'Product Advertising',
                    'Priority Listings',
                    'Sponsored Ads',
                ], JSON_THROW_ON_ERROR),
                'button_rows' => null,
                'image_path' => 'images/case-study-photo-1.jpg',
                'sort_order' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Turn limited-time offers into bold visual stories that drive action.',
                'copy' => 'Use campaign-specific artwork and messaging to support holiday promotions, awareness pushes, or time-sensitive banner placements.',
                'detail' => null,
                'footer' => null,
                'highlights' => null,
                'button_rows' => null,
                'image_path' => 'images/case-study-photo-2.jpg',
                'sort_order' => 2,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Advertisement options available for all types of businesses and budgets',
                'copy' => null,
                'detail' => null,
                'footer' => 'When it comes to advertising, there\'s only one place to be: right here.',
                'highlights' => null,
                'button_rows' => json_encode([
                    ['Banner Ads', 'Contractor Listing Ads', 'Contractors Display Ads'],
                    ['Native Ads', 'Shoppable Ads', 'GIF Ads'],
                    ['Listing Ads', 'Product Ads', 'Search Page Display Ads'],
                ], JSON_THROW_ON_ERROR),
                'image_path' => 'images/hero-scene.svg',
                'sort_order' => 3,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};
