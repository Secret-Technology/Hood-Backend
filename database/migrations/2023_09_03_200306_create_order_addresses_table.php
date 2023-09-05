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
        Schema::create('order_addresses', function (Blueprint $table) {
            $table->id();
            $table->text('from')->nullable();
            $table->text('to')->nullable();

            $table->longText('extra_routes')->nullable();

            $table->foreignId('from_address')->nullable()->references('id')->on('addresses')->onDelete('cascade');
            $table->foreignId('to_address')->nullable()->references('id')->on('addresses')->onDelete('cascade');

            $table->foreignId('order_id')->nullable()->references('id')->on('orders')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_addresses');
    }
};
