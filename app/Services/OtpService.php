<?php

namespace App\Services;

use App\Exceptions\GlobalException;
use App\Models\Otp;
use App\Utility\GenerateOtp;
use Carbon\Carbon;
use Exception;

class OtpService
{
    /**
     * otpExpireCheck
     *
     * @param  mixed  $request
     * @return void
     *
     * @throws GlobalException
     */
    public static function sendOtp($request)
    {
        try {            
            $smsOtp = GenerateOtp::otpGenerate(4);
            $expireTime = Carbon::now(env('TIME_ZONE'));
            $expireDate = strtotime($expireTime);
            $expirationTime = config('constants.sms_expired_time');
            $futureDate = $expireDate + ($expirationTime['second']);
            $formatDate = date('Y-m-d H:i:s', $futureDate);
            Otp::updateOrCreate(
                [
                    'email' => $request->email,
                    'mobile_number' => $request->mobile_number,
                    'status' => '0',
                    'type' => $request->otp_type,
                ],
                [
                    'email' => $request->email,
                    'mobile_number' => $request->mobile_number,
                    'otp' => $smsOtp,
                    'expired_at' => $formatDate,
                    'type' => $request->otp_type,
                ]
            );            
            // SendSmsService::sentSms($request->email, $request->mobile_number, $smsOtp);
        } catch (Exception $e) {
            throw new GlobalException($e->getMessage());
        }
    }
}
