<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\User;

class ConvertDataUserLevel extends Migration
{

    public function up() {
        $allUser = User::where(['is_delete' => 0])->get();
        $userBuilded = $this->rebuilUser($allUser);
        foreach ($allUser as $user){
            if(!isset($userBuilded[$user->reflink])){
                continue;
            }
            $_u                 = $userBuilded[$user->reflink];
            $user->level        = $_u['level'];
            $user->super_parent = $_u['super_parent'];
            $user->save();
        }
    }
    private function rebuilUser($users): array
    {
        $result = [];
        foreach ($users as $user){
            $level          = $this->getLevel($result, $user->upline_by);
            $superParent    = $this->getParent($result, $user->upline_by, $user->reflink);
            $result[$user->reflink] = [
                'reflink'       => $user->reflink,
                'upline_by'     => $user->upline_by,
                'level'         => $level,
                'super_parent'  => $superParent
            ];
        }
        return $result;
    }
    private function getLevel($aryUser, $reflink): int
    {
        foreach ($aryUser as $user){
            if($user['reflink'] == $reflink){
                return (int)$user['level'] + 1;
            }
        }
        return 0;
    }
    private function getParent($aryUser, $reflink, $ref = ''): string
    {
        foreach ($aryUser as $user){
            if($user['reflink'] == $reflink){
                $parent = json_decode($user['super_parent'], 1);
                $parent[] = $ref;
                return json_encode($parent, 1);
            }
        }
        return json_encode([$ref]);
    }
}
