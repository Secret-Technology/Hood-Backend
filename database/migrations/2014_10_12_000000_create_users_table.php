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
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('username', 25)->unique()->nullable();

            $table->string('email')->nullable();
            $table->timestamp('email_verified_at')->nullable();

            $table->string('password');
            $table->string('forget_password_code')->nullable();

            $table->string('phone_code');
            $table->string('phone', 14);
            $table->boolean('phone_confirmed')->default(false);

            $table->string('img')->nullable();

            $table->string('address')->nullable();

            $table->string('timezone')->nullable();

            $table->boolean('is_active')->default(false);
            $table->boolean('is_banned')->default(false);
            $table->boolean('is_data_completed')->default(false);

            $table->string('email_confirmation_token')->nullable();
            $table->string('phone_confirmation_token')->nullable();

            $table->string('otp')->nullable();

            $table->string('identity_no')->nullable();

            $table->string('referral_code')->nullable();
            $table->unsignedInteger('referred_by')->nullable();

            $table->string('lang')->nullable();

            $table->float('rate')->default(0);

            $table->enum('login_by', ['android', 'ios'])->nullable();
            $table->ipAddress('last_known_ip')->nullable();
            $table->timestamp('last_login_at')->nullable();

            $table->string('lat')->nullable();
            $table->string('lng')->nullable();

            $table->string('wallet')->nullable()->default(0);

            $table->foreignId('country_id')->nullable()->references('id')->on('countries')->onDelete('cascade');

            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
