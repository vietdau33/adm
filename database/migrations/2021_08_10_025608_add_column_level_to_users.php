<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnLevelToUsers extends Migration
{

    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer("level")->default(0);
            $table->string("rate_ib")->default("0");
            $table->string("super_parent")->default("");
        });
    }
}
