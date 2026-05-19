<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('title');
            $table->string('status')->default('Draft');
            $table->string('format');
            $table->string('objective');
            $table->unsignedInteger('daily_budget')->default(0);
            $table->string('headline');
            $table->text('copy');
            $table->string('cta');
            $table->date('start_date');
            $table->date('end_date');
            $table->json('placements')->nullable();
            $table->json('metrics')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('campaigns');
    }
};
