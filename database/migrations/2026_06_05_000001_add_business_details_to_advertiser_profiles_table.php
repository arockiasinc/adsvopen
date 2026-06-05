<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('advertiser_profiles', function (Blueprint $table) {
            $table->string('business_name')->nullable()->after('user_id');
            $table->string('industry')->nullable()->after('business_name');
            $table->string('business_province')->nullable()->after('industry');
            $table->string('company_size')->nullable()->after('business_province');
            $table->string('website')->nullable()->after('company_size');
        });
    }

    public function down(): void
    {
        Schema::table('advertiser_profiles', function (Blueprint $table) {
            $table->dropColumn([
                'business_name',
                'industry',
                'business_province',
                'company_size',
                'website',
            ]);
        });
    }
};
