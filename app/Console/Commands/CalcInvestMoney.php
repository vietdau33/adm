<?php

namespace App\Console\Commands;

use App\Models\HistorySystemSetting;
use Illuminate\Console\Command;
use App\Models\User;
use App\Models\SystemSetting;

class CalcInvestMoney extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calc:invest-money';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Add and subtract user's invest money";

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @return void
     */
    public function handle(): void
    {
        $this->calcRateUser();
    }

    private function calcRateUser(): void
    {
        $rate = SystemSetting::where(['type' => 'rate'])->first();
        HistorySystemSetting::__insert([
            'type' => 'rate',
            'value' => (float)$rate->value,
            'is_daily' => 1
        ]);
        if($rate == null){
            $this->info("Rate setting null!");
            return;
        }
        $rate = (float)$rate->value;
        $users = User::where(['is_delete' => 0])->get();
        foreach ($users as $user){
            if($user->role == 'admin'){
                continue;
            }
            $wallet = (float)$user->money_wallet;
            $invest = (float)$user->money_invest;
            $user->money_wallet = round($wallet + $invest * $rate / 100, 2);
            $user->money_invest = round($invest - $invest * $rate / 100, 2);
            $user->save();
        }
    }
}
