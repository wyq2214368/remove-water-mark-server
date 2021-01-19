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
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('api_token', 80)->unique()->nullable();
            $table->string('openid')->unique()->nullable();
            $table->string('unionid')->unique()->nullable();
            $table->string('avatar')->default('')->comment('头像');
            $table->unsignedTinyInteger('gender')->nullable()->comment('性别（1男|0女）');
            $table->string('country')->default('')->comment('国别');
            $table->string('province')->default('')->comment('省份');
            $table->string('city')->default('')->comment('城市');
            $table->timestamps();
        });
        \Illuminate\Support\Facades\DB::statement("ALTER TABLE users AUTO_INCREMENT=100001");
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
