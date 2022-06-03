<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\SystemSetting;

class AddSettingIB extends Migration
{
    public function up() {
        SystemSetting::__insert([
            'type' => 'max-ib',
            'value' => "5"
        ]);
        SystemSetting::__insert([
            'type' => 'max-ib-user',
            'value' => "5"
        ]);
    }
}
