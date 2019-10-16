<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->bigIncrements('id');
            $table->string('name', 128);
            $table->string('email', 128)->unique();
            $table->string('phone_number', 32)->unique();
            $table->string('password', 128);
            $table->bigInteger('reward_points')->default(0);
            $table->date('email_verified_at')->nullable();
            $table->string('email_verification_token', 80)->nullable();
            $table->string('facebook_id', 32)->nullable();
            $table->string('google_id', 32)->nullable();
            $table->rememberToken();
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
