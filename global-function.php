<?php

use App\Models\SystemSetting;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\JsonResponse;

function logined(): bool
{
    return auth()->check();
}

function user(): ?Authenticatable
{
    if(!logined()) {
        echo '<script>alert("Not loggin! Please Login!")</script>';
        exit(1);
    }
    return auth()->user();
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

function system_setting($name = null){
    return $name == null ? new SystemSetting() : SystemSetting::getSetting($name);
}

function returnValidatorFail($validator): JsonResponse
{
    $message = $validator->errors()->messages();
    $message = array_reduce($message, function($a, $b){
        return array_merge($a, array_values($b));
    }, []);
    return jsonError(implode("\n", $message));
}
