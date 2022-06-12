<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDaylyTodayToInvestmentBought extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('investment_bought', function (Blueprint $table) {
            $table->tinyInteger('daily_today')->default(0)->after('max_withdraw');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('investment_bought', function (Blueprint $table) {
            //
        });
    }
}
