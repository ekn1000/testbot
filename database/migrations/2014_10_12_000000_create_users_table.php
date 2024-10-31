<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->uuid('uuid')->nullable();
            $table->string('password');
            $table->string('token', 64)->nullable();
            $table->bigInteger('telegram_id')->unique();
            $table->string('tg_first_name', 255)->default('');
            $table->string('tg_last_name', 255)->nullable();
            $table->string('tg_username', 191)->nullable();
            $table->unsignedBigInteger('referrer_id')->nullable();
            $table->uuid('referrer_uuid', 255)->nullable();
            $table->string('referral_token', 32)->unique();
            $table->unsignedTinyInteger('referral_percent')->default(0);
            $table->unsignedSmallInteger('total_referrals')->default(0);//кол-во Реф-ов
            $table->decimal('balance', 10, 0)
                ->default(0);
            $table->string('phone')->nullable();
            $table->string('company_name')->nullable();
            $table->rememberToken();
            $table->boolean('active')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
