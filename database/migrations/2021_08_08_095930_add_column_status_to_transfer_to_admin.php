<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnStatusToTransferToAdmin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('transfer_to_admin', function (Blueprint $table) {
            $table->integer('status')->default(0)->after("note");
            $table->string('admin_submit')->default("")->after("status");
        });
    }
}
