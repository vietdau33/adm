<?php

use App\Http\Services\ModelService;
use App\Models\Settings;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
        $table->id();
        $table->integer('user_id');
        $table->string('guard');
        $table->string('type');
        $table->json('setting_data');
        $table->timestamps();
    });

        $defaultSettingProfit = [
            'profit' => 0,
            'days' => 0,
            'min_amount' => 0,
            'max_withdraw' => 0,
            'active' => 1
        ];
        ModelService::insert(Settings::class, [
            'user_id' => 0,
            'guard' => 'admin',
            'type' => 'profit',
            'setting_data' => json_encode([
                'bronze' => $defaultSettingProfit,
                'silver' => $defaultSettingProfit,
                'gold' => $defaultSettingProfit,
                'platinum' => $defaultSettingProfit
            ])
        ]);

        $defaultSettingBonus = [
            'bonus' => 0,
            'condition_f1' => 0
        ];
        ModelService::insert(Settings::class, [
            'user_id' => 0,
            'guard' => 'admin',
            'type' => 'bonus',
            'setting_data' => json_encode([
                'level_1' => $defaultSettingBonus,
                'level_2' => $defaultSettingBonus,
                'level_3' => $defaultSettingBonus,
                'level_4' => $defaultSettingBonus,
                'level_5' => $defaultSettingBonus,
                'minimum_to_bonus' => 300
            ])
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
