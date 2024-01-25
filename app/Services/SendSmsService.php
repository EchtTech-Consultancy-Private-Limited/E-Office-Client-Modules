<?php

namespace App\Services;

use App\Exceptions\GlobalException;
use Exception;
use App\Mail\OtpSend;
use Mail;

class SendSmsService
{
    /**
     * @sentSms
     *
     *  send sms otp on mobile
     *
     * @param  mixed  $mobile_number
     * @param  mixed  $smsOtp
     * @return void
     */
    public static function sentSms($email,$mobile_number, $smsOtp)
    {
        try {
            Mail::to($email)->send(new OtpSend($smsOtp));
        } catch (Exception $e) {
            throw new GlobalException($e->getMessage());
        }
    }
    
}
