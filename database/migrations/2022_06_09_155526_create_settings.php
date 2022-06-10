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

        $this->createDefaultConfigProfit();
        $this->createDefaultConfigBonus();
    }

    private function createDefaultConfigProfit () {
        ModelService::insert(Settings::class, [
            'user_id' => 0,
            'guard' => 'admin',
            'type' => 'profit',
            'setting_data' => json_encode([
                'bronze' => [
                    'profit' => 0.5,
                    'days' => 0,
                    'min_amount' => 100,
                    'max_withdraw' => 270,
                    'active' => 1
                ],
                'silver' => [
                    'profit' => 1.3,
                    'days' => 90,
                    'min_amount' => 100,
                    'max_withdraw' => 270,
                    'active' => 1
                ],
                'gold' => [
                    'profit' => 0.8,
                    'days' => 180,
                    'min_amount' => 100,
                    'max_withdraw' => 270,
                    'active' => 1
                ],
                'platinum' => [
                    'profit' => 0.7,
                    'days' => 270,
                    'min_amount' => 100,
                    'max_withdraw' => 270,
                    'active' => 1
                ]
            ])
        ]);
    }

    private function createDefaultConfigBonus () {
        ModelService::insert(Settings::class, [
            'user_id' => 0,
            'guard' => 'admin',
            'type' => 'bonus',
            'setting_data' => json_encode([
                'level_1' => [
                    'bonus' => 7,
                    'condition_f1' => 0
                ],
                'level_2' => [
                    'bonus' => 5,
                    'condition_f1' => 2
                ],
                'level_3' => [
                    'bonus' => 3,
                    'condition_f1' => 3
                ],
                'level_4' => [
                    'bonus' => 1,
                    'condition_f1' => 4
                ],
                'level_5' => [
                    'bonus' => 1,
                    'condition_f1' => 5
                ],
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
