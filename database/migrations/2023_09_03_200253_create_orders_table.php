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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->nullable()->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('driver_id')->nullable()->references('id')->on('drivers')->onDelete('cascade');
            $table->foreignId('package_id')->nullable()->references('id')->on('packages')->onDelete('cascade');

            $table->string('distance')->default(0);
            $table->string('time')->default(0);

            $table->longText('google_route')->nullable();

            $table->string('status');
            $table->longText('status_times')->nullable();

            $table->string('payment_type')->nullable(); // cash - digital - wallet

            $table->longText('note')->nullable();

            $table->string('fare_price')->nullable();
            $table->string('user_fare_price')->nullable();
            $table->string('accepted_fare_price')->nullable();

            $table->string('driver_fare')->nullable();
            $table->string('tip')->nullable();

            $table->string('app_percent')->nullable();
            $table->string('app_amount')->nullable();

            $table->string('vat_percent')->nullable();
            $table->string('vat_amount')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
