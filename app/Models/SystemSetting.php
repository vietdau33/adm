<?php

namespace App\Models;

use App\Http\Helpers\Helper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use stdClass;

class SystemSetting extends Model
{
    use HasFactory;

    protected $table = 'system_settings';

    public static function __insert($aryData){
        $model = new self;
        foreach ($aryData as $key => $val){
            $model->{$key} = $val;
        }
        $model->save();
        return $model;
    }

    public static function buildSetting(): stdClass
    {
        $setting = self::all()->toArray();
        $setting = array_reduce($setting, function($a, $b){
            $a[$b['type']] = $b['value'];
            return $a;
        }, []);
        return Helper::generateStdClass($setting);
    }

    public static function changeSetting($type, $value, $insertIfNotExists = false): array
    {
        $setting = self::where(['type' => $type])->first();
        if($setting == null){
            if(!$insertIfNotExists){
                return [
                    'success' => false,
                    'message' => 'Setting not found!'
                ];
            }
            $setting = new self;
            $setting->type = $type;
        }
        $setting->value = $value;
        $setting->save();
        HistorySystemSetting::saveHistory($type, $value);
        return [
            'success' => true,
            'message' => 'Setting save success!'
        ];
    }

    public static function validateSettingRate($value)
    {
        $value = (float)$value;
        if($value < 0 || $value > 2){
            return [
                'success' => false,
                'message' => 'Value of Rate Setting must be from 0 to 2!'
            ];
        }
    }
    public static function validateSettingBonus($value){
        $value = (int)$value;
        if($value < 0 || $value > 100){
            return [
                'success' => false,
                'message' => 'Value of Rate Setting must be from 0 to 100!'
            ];
        }
    }

    public static function getSetting($name, $default = null){
        $setting = self::buildSetting();
        return $setting->{$name} ?? $default;
    }

    public static function getRateCrypto($name = null){
        $recordCrypto = self::where("type", 'like', 'rate_%')->get()->toArray();
        $setting = array_reduce($recordCrypto, function($a, $b){
            $type = explode('-', $b['type']);
            $a[$type[1]][$type[2]] = $b['value'];
            return $a;
        }, []);
        return $name == null ? $setting : $setting[$name];
    }

    public static function getDefaultSizePagination(): int
    {
        return (int)(self::where(['type' => 'default-size-pagination'])->first()->value ?? 0);
    }

    public function _getDefaultSizePagination(): int
    {
        return self::getDefaultSizePagination();
    }

    public static function saveInterestRateSolo($request): array
    {
        $params = $request->only(['3month', '6month', '12month']);
        foreach ($params as $name => $value){
            $result = self::changeSetting("interest_rate_$name", $value, true);
        }
        return $result;
    }
    public static function saveBonusSolo($request): array
    {
        $params = $request->only(['referral-bonus', 'verify-bonus']);
        foreach ($params as $name => $value){
            $result = self::changeSetting("solo-$name", $value, true);
        }
        return $result;
    }
    public static function saveWithdrawSolo($request): array
    {
        $params = $request->only(['number-of-day', 'withdraw-rate']);
        foreach ($params as $name => $value){
            $result = self::changeSetting($name, $value, true);
        }
        return $result;
    }
}
