<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnBonusToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->tinyInteger('bonus_received_type1')
                ->default(0)
                ->comment('Mark upline users who have received bonus when referring themselves or not!');
            $table->tinyInteger('bonus_received_type2')
                ->default(0)
                ->comment('Mark yourself as receiving a bonus when the person you refer invests more than you!');
        });
    }

}
