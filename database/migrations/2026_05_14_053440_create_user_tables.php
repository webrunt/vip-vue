<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Drop default laravel users table and recreate with our schema
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');

        Schema::create('user_roles', function (Blueprint $table) {
            $table->smallIncrements('user_role_id');
            $table->string('role_name');
            $table->smallInteger('status')->default(0);
            $table->timestamps();
        });

        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username');
            $table->string('email')->unique();
            $table->string('password')->nullable();
            $table->string('security_pin')->nullable();
            $table->unsignedSmallInteger('role_id')->default(0);
            $table->string('activation_code')->nullable();
            $table->string('forgot_code')->nullable();
            $table->timestamp('date_activated')->nullable();
            $table->timestamp('last_login')->nullable();
            $table->smallInteger('is_blocked')->default(0);
            $table->smallInteger('is_active')->default(0);
            $table->smallInteger('is_corpo')->default(0);
            $table->string('shop_name')->nullable();
            $table->boolean('shop_activated')->default(false);
            $table->integer('num_used')->default(0);
            $table->string('unhash_password')->default('');
            $table->string('unhash_security_pin')->default('');
            $table->string('temp_password')->nullable();
            $table->timestamp('last_activity_date')->nullable();
            $table->string('last_activity')->default('');
            $table->rememberToken();
            $table->string('otp')->default('');
            $table->date('last_otp')->nullable();
            $table->string('otp_step')->default('');
            $table->integer('left_build')->default(0);
            $table->timestamps();

            $table->foreign('role_id')->references('user_role_id')->on('user_roles');
            $table->index('role_id');
        });

        Schema::create('user_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('leader_id')->nullable();
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->date('dob')->nullable();
            $table->longText('pob')->nullable();
            $table->string('citizenship')->default('Filipino');
            $table->string('mobile')->nullable();
            $table->integer('mobile_verified')->default(0);
            $table->string('telephone')->nullable();
            $table->longText('address')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->string('tin_number')->nullable();
            $table->enum('civil_status', ['single', 'married', 'divorced', 'widow'])->default('single');
            $table->string('bank_acct_name')->nullable();
            $table->string('bank_acct_number')->nullable();
            $table->string('uniquecode')->nullable();
            $table->integer('neo_cutoff')->nullable();
            $table->decimal('neo_funds', 10, 2)->nullable();
            $table->integer('user_membership')->default(0);
            $table->smallInteger('is_profile_complete')->default(0);
            $table->smallInteger('is_affiliate')->default(0);
            $table->smallInteger('encashment')->default(0);
            $table->integer('monthly_income_monitor')->default(0);
            $table->integer('auto_maintain_required')->default(0);
            $table->integer('pv_maintain')->default(0);
            $table->integer('apple_points')->default(0);
            $table->text('apple_points_transferred')->nullable();
            $table->text('apple_points_received')->nullable();
            $table->text('apple_points_claim_history')->nullable();
            $table->integer('apple_points_for_processing')->default(0);
            $table->string('digital_card_id', 25)->nullable();
            $table->timestamp('digital_card_generated_at')->nullable();
            $table->boolean('digital_card_active')->default(true);
            $table->string('profile_picture')->nullable();
            $table->timestamp('profile_picture_updated_at')->nullable();
            $table->tinyInteger('terms_accepted')->default(0);
            $table->timestamp('terms_accepted_at')->nullable();
            $table->integer('leaderboard')->default(0);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->index('user_id');
            $table->index('leader_id');
        });

        Schema::create('user_affiliates', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('referral_id')->default(0);
            $table->bigInteger('user_id')->default(0);
            $table->bigInteger('code_id')->default(0);
            $table->smallInteger('desired_package')->default(0);
            $table->smallInteger('is_approved')->default(0);
            $table->string('ebp_code')->nullable();
            $table->smallInteger('ebp_active')->default(0);
            $table->string('uniquecode')->nullable();
            $table->timestamps();

            $table->index('user_id');
            $table->index('referral_id');
        });

        Schema::create('user_wallet', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->decimal('amount', 10, 2)->nullable()->default(0.00);
            $table->integer('gc_points')->nullable()->default(0);
            $table->integer('status')->nullable();
            $table->integer('no_transfer_all')->default(0);
            $table->timestamps();

            $table->index('user_id');
        });

        Schema::create('user_wallet_history', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->integer('head_id')->nullable();
            $table->string('type', 45)->nullable();
            $table->decimal('head_income', 10, 2)->nullable();
            $table->integer('head_gc')->nullable();
            $table->dateTime('datecreated')->nullable();
            $table->timestamps();

            $table->index('user_id');
        });

        Schema::create('user_sms_setting', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('mobile_number');
            $table->decimal('balance', 8, 2);
            $table->boolean('starter')->default(false);
            $table->boolean('premium')->default(false);
            $table->boolean('stairstep')->default(false);
            $table->boolean('unilevel')->default(false);
            $table->boolean('affiliate')->default(false);
            $table->integer('message_count')->default(0);
            $table->boolean('active')->default(false);
            $table->timestamps();

            $table->index('user_id');
        });

        Schema::create('user_sms_message_history', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->string('message_option');
            $table->text('message');
            $table->integer('message_id')->default(0);
            $table->string('message_status')->default('Pending');
            $table->json('response');
            $table->decimal('user_balance', 8, 2);
            $table->timestamps();

            $table->index('user_id');
        });

        Schema::create('user_sms_load_history', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->decimal('amount', 8, 2);
            $table->timestamps();

            $table->index('user_id');
        });

        // Recreate Laravel standard tables
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('user_sms_load_history');
        Schema::dropIfExists('user_sms_message_history');
        Schema::dropIfExists('user_sms_setting');
        Schema::dropIfExists('user_wallet_history');
        Schema::dropIfExists('user_wallet');
        Schema::dropIfExists('user_affiliates');
        Schema::dropIfExists('user_details');
        Schema::dropIfExists('users');
        Schema::dropIfExists('user_roles');
    }
};
