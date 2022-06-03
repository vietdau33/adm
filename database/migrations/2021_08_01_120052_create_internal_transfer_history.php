<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInternalTransferHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('internal_transfer_history', function (Blueprint $table) {
            $table->id();
            $table->string('userid');
            $table->string('to_username');
            $table->string('amount');
            $table->text('note');
            $table->timestamp_custom();
        });
    }
}
