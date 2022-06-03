<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\SystemSetting;

class AddMethodCryptoToSystemSetting extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        SystemSetting::__insert([
            'type' => 'crypto-method',
            'value' => json_encode(['USDT', 'BTC', 'ETH'])
        ]);
        SystemSetting::__insert([
            'type' => 'rate-deposit-USDT',
            'value' => '1.30434782'
        ]);
        SystemSetting::__insert([
            'type' => 'rate-deposit-BTC',
            'value' => '0.00003571'
        ]);
        SystemSetting::__insert([
            'type' => 'rate-deposit-ETH',
            'value' => '0.00051945'
        ]);
        SystemSetting::__insert([
            'type' => 'rate-withdraw-USDT',
            'value' => '1.20434782'
        ]);
        SystemSetting::__insert([
            'type' => 'rate-withdraw-BTC',
            'value' => '0.00003297'
        ]);
        SystemSetting::__insert([
            'type' => 'rate-withdraw-ETH',
            'value' => '0.00047962'
        ]);
    }

}
