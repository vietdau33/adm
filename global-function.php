<?php

use App\Exceptions\UserException;
use App\Http\Helpers\UserHelper;
use App\Models\SystemSetting;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

function user(): ?Authenticatable
{
    return auth()->check() ? auth()->user() : null;
}

function jsonError($message, $redirect = null): JsonResponse
{
    return response()->json([
        'success' => false,
        'message' => $message,
        'redirect' => $redirect ?? ''
    ]);
}

function jsonSuccess($message, $redirect = null): JsonResponse
{
    return response()->json([
        'success' => true,
        'message' => $message,
        'redirect' => $redirect ?? ''
    ]);
}

function jsonSuccessData($data, $message = ""): JsonResponse
{
    return response()->json([
        'success' => true,
        'message' => $message,
        'datas'   => $data
    ]);
}

function __d($date, $format = "Y/m/d H:i"){
    $date = str_replace('/', '-', $date);
    return date($format, strtotime($date));
}

function calcRateIB($aryRef): float
{
    $maxIB = SystemSetting::getSetting('max-ib');
    $aryRate = UserHelper::getIBRateWithArrayRef($aryRef);
    $sumRate = UserHelper::ibRateCalcType2($aryRate);
    return (float)$maxIB - (float)$sumRate;
}

function calcIBRealRecive($tree, $user){
    $superParent = json_decode($user->super_parent, 1);
    $reflink = $user->reflink;
    if($reflink == end($tree)){
        return 0;
    }
    $treeFake = $tree;
    array_pop($treeFake);
    if($reflink == end($treeFake)){
        return (float)$user->rate_ib;
    }
    $struct = array_diff($tree, $superParent);
    $struct = array_merge([$reflink], $struct);
    $aryRate = UserHelper::getIBRateWithArrayRef($struct);
    $aryRate = array_reverse($aryRate);
    array_pop($aryRate);
    $prevRate = $sum = null;
    foreach ($aryRate as $rate){
        $rate = (float)$rate;
        if($sum == null){
            $prevRate = $sum = $rate;
            continue;
        }
        $sum += ($rate - $prevRate);
        $prevRate = $rate;
    }
    $sum = (float)$user->rate_ib - $sum;
    return $sum > 0 ? $sum : 0;
}

/**
 * @throws UserException
 */
function getUserUpline($reflink){
    return User::getUserByReflink($reflink, true);
}

function getUserByArrayRef($arrayRef){
    return User::getUserByArrayReflink($arrayRef);
}

function system_setting($name = null){
    return $name == null ? new SystemSetting() : SystemSetting::getSetting($name);
}

function returnValidatorFail($validator): JsonResponse
{
    $message = $validator->errors()->messages();
    $message = array_reduce($message, function($a, $b){
        $a = array_merge($a, array_values($b));
        return $a;
    }, []);
    return jsonError(implode("\n", $message));
}

function fakePagination(): LengthAwarePaginator
{
    $items = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
    $items = Collection::make($items);
    return new LengthAwarePaginator(
        $items->forPage(1, 1),
        $items->count(),
        1,
        1
    );
}
