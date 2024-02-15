<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('ads', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('ad_id')->index()->nullable();
            $table->integer('impressions')->nullable();
            $table->integer('clicks')->nullable();
            $table->integer('unique_clicks')->nullable();
            $table->integer('leads')->nullable();
            $table->integer('conversion')->nullable();
            // Not specified how precisely the data needs to be stored, storing with float would be less precise
            $table->decimal('roi', 17, 12)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ads');
    }
};
