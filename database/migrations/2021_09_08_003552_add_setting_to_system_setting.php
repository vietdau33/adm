<?php

use App\Models\SystemSetting;
use Illuminate\Database\Migrations\Migration;

class AddSettingToSystemSetting extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        SystemSetting::__insert([
            'type' => 'default-size-pagination',
            'value' => 10
        ]);
    }
}
