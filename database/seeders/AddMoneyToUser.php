<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AddMoneyToUser extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::where(['is_delete' => 0])->get();
        foreach ($users as $user){
            if(empty($user->money_invest)){
                $user->money_invest = "0";
            }
            if(empty($user->money_wallet)){
                $user->money_wallet = "0";
            }
            $user->save();
        }
    }
}
