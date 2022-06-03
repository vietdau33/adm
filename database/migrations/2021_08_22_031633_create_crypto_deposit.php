<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCryptoDeposit extends Migration
{

    public function up()
    {
        Schema::create('crypto_deposit', function (Blueprint $table) {
            $table->id();
            $table->string('user_transfer');
            $table->string('method');
            $table->string('rate');
            $table->string('amount');
            $table->string('from');
            $table->string('to');
            $table->string('note')->default('')->nullable();
            $table->string('txhash');
            $table->timestamp_custom();
        });
    }

}
