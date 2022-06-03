<?php

use App\Exceptions\UserException;
use App\Models\SystemSetting;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnRefByAdminToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->tinyInteger("ref_is_admin")->default(0);
        });
        $this->convertData();
    }

    /**
     * @throws UserException
     */
    private function convertData(){
        $users = User::where(['is_delete' => 0])->get();
        $maxIB = SystemSetting::getSetting('max-ib', 0);
        foreach ($users as $user){
            $uplineBy = $user->upline_by ?? '';
            if($uplineBy == ''){
                continue;
            }
            $ref = User::getUserByReflink($uplineBy, true);
            if($ref == null){
                continue;
            }
            if($ref->role == 'admin'){
                $user->ref_is_admin = 1;
                $user->rate_ib = $maxIB;
                $user->save();
            }
        }
    }
}
