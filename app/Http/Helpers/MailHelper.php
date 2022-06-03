<?php

namespace App\Http\Helpers;

use App\Mail\OtpMail;
use Illuminate\Support\Facades\Mail;

class MailHelper{

    /**
     * @param array $aryData
     * @return void
     */
    public static function sendOtp(array $aryData, $view = null): void
    {
        if($view == null){
            $view = env('MAIL_VIEW');
        }
        $aryData['view'] = $view;
        $mail = Helper::generateStdClass($aryData);
        $otpMail = new OtpMail($mail);
        Mail::to($mail->email)->send($otpMail);
    }
}
