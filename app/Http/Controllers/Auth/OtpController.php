<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\ResendEmailVarification;
use App\Models\User;
use App\Services\OtpService;
use Illuminate\Http\Request;
use Mail;

class OtpController extends Controller
{
    /**
     * resendOtp
     *
     * @param  mixed  $request
     * @return void
     */
    public function resendOtp(Request $request)
    {
        OtpService::sendOtp($request);
        return response()->json([
            'status' => 200,
            'message' => "OTP send Successfull !",
        ], 200);
    }

}
