<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvestmentBought extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('investment_bought', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->string('type');
            $table->double('money_buy');
            $table->double('profit');
            $table->double('days');
            $table->double('min_amount');
            $table->double('max_withdraw');
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
        Schema::dropIfExists('investment_bought');
    }
}
