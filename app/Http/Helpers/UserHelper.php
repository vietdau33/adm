<?php

namespace App\Http\Helpers;

use App\Exceptions\UserException;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class UserHelper{

    public static function rebuildStructUser($collectionUser, $reflink){
        $allUserChild = $collectionUser->filter(function($child) use ($reflink){
            $superParent = json_decode($child->super_parent, 1);
            return in_array($reflink, $superParent);
        });
        $aryUserUpline  = [];
        $allUserChild   = $allUserChild->sortBy("level");
        $levelMin       = $allUserChild[0]->level;

        return $allUserChild->map(
            /**
            * @throws UserException
            */
            function($child) use ($levelMin, &$aryUserUpline){
            $child = $child->only([
                'created_at',
                'username',
                'phone',
                'money_invest',
                'money_wallet',
                'upline_by',
                'level',
                'reflink',
                'rate_ib',
                'super_parent',
            ]);

            if(!isset($aryUserUpline[$child['upline_by']])){
                $userUpline = User::getUserByReflink($child['upline_by'], true);
                $aryUserUpline[$child['upline_by']] = [];
                $aryUserUpline[$child['upline_by']]['username'] = $userUpline->username ?? '';
                $aryUserUpline[$child['upline_by']]['role']     = $userUpline->role ?? 'user';
            }

            if(Auth::user()->username != $child['username'] && Auth::user()->role != 'admin'){
                $child['money_invest'] = '******';
                $child['money_wallet'] = '******';
            }
            $dataUplineBy            = $aryUserUpline[$child['upline_by']];
            $child['created_at']     = __d($child['created_at']);
            $child['super_parent']   = json_decode($child['super_parent'], 1);
            $child['children']       = [];
            $child['level_fake']     = $child['level'] - $levelMin;
            $child['upline_by']      = $dataUplineBy['username'];
            $child['upline_by_role'] = $dataUplineBy['role'];
            return $child;
        })->toArray();
    }

    public static function buildTreeUser($users){
        $userStruct = [];
        for($i = 0; $i <= 10; $i++){
            $filter = array_filter($users, function($_u) use ($i){
                return $_u['level'] == $i;
            });
            $userStruct[$i] = array_values($filter);
        }
        foreach ($users as $key => $user){
            $users[$key]['children'] = self::getChildren($userStruct, $user['level'] + 1, $user['reflink']);
        }
        return $users;
    }

    public static function getChildren($users, $level, $reflink){
        if(empty($users[$level])){
            return [];
        }
        return array_filter($users[$level], function($user) use($reflink){
            return $user['upline_by'] == $reflink;
        });
    }

    public static function ibRateCalc($aryRef, $popArray = false){
        if($popArray){
            array_pop($aryRef);
        }
        $ibRate = 0;
        $users = User::getUserByArrayReflink($aryRef);
        foreach ($users as $user){
            $ibRate += (float)$user->rate_ib;
        }
        return $ibRate;
    }

    public static function ibRateCalcType2($aryIbRate){
        $sum = null;
        $prevRate = 0;
        foreach ($aryIbRate as $rate){
            $rate = (float)$rate;
            if($sum == null){
                $sum = $prevRate = $rate;
                continue;
            }
            if($rate < $prevRate){
                continue;
            }
            $sum += ($rate - $prevRate);
        }
        return $sum;
    }

    public static function getIBRateWithArrayRef($aryRef, $popArray = false){
        if($popArray){
            array_pop($aryRef);
        }
        return User::getUserByArrayReflink($aryRef)
                    ->filter(function($user){
                        return $user->role != 'admin' && User::getUserByReflink($user->upline_by)->role != 'admin';
                    })
                    ->map(function($user){
                        return $user->rate_ib;
                    })->toArray();
    }

    public static function returnErrorIBMax($maximum, $struct): JsonResponse
    {
        return jsonError("The IB cannot be set because the value will exceed the maximum allowed value.\nThe maximum that can be placed is $maximum.\nStruct max: " . implode(" > ", $struct));
    }
    public static function returnErrorIBMax2($maximum, $struct): JsonResponse
    {
        return jsonError("Maximum can set is $maximum.\nStruct: " . implode(" > ", $struct));
    }
}
