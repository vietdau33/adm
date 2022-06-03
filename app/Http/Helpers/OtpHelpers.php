<?php

namespace App\Http\Helpers;

use Carbon\Carbon;
use Seshac\Otp\Models\Otp as OtpModel;
use Illuminate\Support\Str;
use Seshac\Otp\Otp;
use stdClass;

class OtpHelpers{

    /**
     * @param int $lengthPublicKey
     * @return stdClass
     */
    public static function generate(int $lengthPublicKey = 16): stdClass
    {
        $key = Str::random($lengthPublicKey);
        $otp = Otp::generate($key);
        return Helper::generateStdClass([
            'otp' => $otp->token,
            'key' => $key
        ]);
    }

    public static function verify($otp, $otpKey, $setExpire = false){
        $valid = Otp::validate($otpKey, $otp);
        if($valid->status && $setExpire){
            self::setExpireToken($otpKey);
        }
        return $valid;
    }

    public static function setExpireToken($otpKey): bool
    {
        $otp = OtpModel::where('identifier', $otpKey)->first();

        if ($otp == null) {
            return false;
        }
        $otp->expired = true;
        $otp->save();
        return true;
    }

}
