<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBonusLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bonus_logs', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->integer('user_id_from');
            $table->double('rate');
            $table->integer('condition_f1');
            $table->double('money_bonus');
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
        Schema::dropIfExists('bonus_logs');
    }
}
