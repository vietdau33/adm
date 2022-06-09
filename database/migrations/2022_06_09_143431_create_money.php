<?php

use App\Http\Services\ModelService;
use App\Models\MoneyModel;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMoney extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('money', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id');
            $table->double('wallet')->default(0);
            $table->double('bonus')->default(0);
            $table->double('profit')->default(0);
            $table->timestamps();
        });
        foreach (User::all() as $user) {
            ModelService::insert(MoneyModel::class, [
                'user_id' => $user->id
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('money');
    }
}
