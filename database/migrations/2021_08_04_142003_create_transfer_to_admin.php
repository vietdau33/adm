<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransferToAdmin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfer_to_admin', function (Blueprint $table) {
            $table->id();
            $table->string("from");
            $table->string('to');
            $table->string('amount');
            $table->string('note')->nullable();
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
        Schema::dropIfExists('transfer_to_admin');
    }
}
