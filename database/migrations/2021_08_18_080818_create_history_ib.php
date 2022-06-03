<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoryIb extends Migration
{

    public function up()
    {
        Schema::create('history_ib', function (Blueprint $table) {
            $table->id();
            $table->string("from");
            $table->string("to");
            $table->string("rate_ib_plus");
            $table->tinyInteger("is_continue")->default(0);
            $table->timestamp_custom();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('history_ib');
    }
}
