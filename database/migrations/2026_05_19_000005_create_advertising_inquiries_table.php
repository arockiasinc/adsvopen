<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('advertising_inquiries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // Acceptance gate (one-month minimum commitment).
            $table->boolean('accepts_terms')->default(false);

            // Business info (auto-filled from the account, editable).
            $table->string('business_name');
            $table->string('industry');
            $table->string('business_province');

            // Sizing & targeting.
            $table->string('company_size');
            $table->json('target_provinces')->nullable();
            $table->json('target_regions')->nullable();

            // Selling on VOpen Market.
            $table->boolean('sells_on_vopen')->default(false);
            $table->string('seller_id')->nullable();

            // Duration & link.
            $table->string('duration');
            $table->boolean('wants_website_link')->default(false);
            $table->string('website_link')->nullable();

            // Ad content.
            $table->string('ad_about');
            $table->string('ad_about_other')->nullable();
            $table->string('display_schedule');

            // Budget.
            $table->string('daily_budget_band');
            $table->unsignedInteger('daily_budget_other')->nullable();

            // Misc flags.
            $table->boolean('advertising_apps')->default(false);
            $table->boolean('special_promotion')->default(false);
            $table->boolean('generic_social_message')->default(false);
            $table->unsignedBigInteger('yearly_marketing_budget')->nullable();
            $table->boolean('is_government_agency')->default(false);

            // Uploaded creative.
            $table->string('digital_file_path')->nullable();

            // Contact snapshot (captured at submission time).
            $table->string('contact_name')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_phone')->nullable();

            // Computed recommendation + admin workflow.
            $table->json('recommendations')->nullable();
            $table->string('status')->default('New');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('advertising_inquiries');
    }
};
