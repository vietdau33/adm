<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCryptoWithdraw extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crypto_withdraw', function (Blueprint $table) {
            $table->id();
            $table->string('user_transfer');
            $table->string('method');
            $table->string('rate');
            $table->string('amount');
            $table->string('to');
            $table->string('note')->default('')->nullable();
            $table->timestamp_custom();
        });
    }

}
