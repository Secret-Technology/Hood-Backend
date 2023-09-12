<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->string('capital')->nullable();
            $table->string('citizenship')->nullable();
            $table->string('country_code')->nullable();
            $table->string('currency')->nullable();
            $table->string('currency_code')->nullable();
            $table->string('currency_sub_unit')->nullable();
            $table->string('full_name')->nullable();
            $table->string('iso_3166_2')->nullable();
            $table->string('iso_3166_3')->nullable();
            $table->string('name')->nullable();
            $table->string('region_code')->nullable();
            $table->string('sub_region_code')->nullable();
            $table->boolean('eea')->default(false);
            $table->string('phone_code')->nullable();
            $table->string('currency_symbol')->nullable();
            $table->string('currency_decimals')->nullable();
            $table->string('flag')->nullable();
            $table->boolean('minLength')->default(0);
            $table->boolean('maxLength')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('countries');
    }
};
