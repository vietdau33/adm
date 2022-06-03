<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsers extends Migration
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
            $table->string('username');
            $table->string('password');
            $table->text("fullname");
            $table->string('email');
            $table->string("phone");
            $table->string("password_old")->default("[]");
            $table->string("otp_key")->default("");
            $table->timestamp_custom();
        });
    }
}
