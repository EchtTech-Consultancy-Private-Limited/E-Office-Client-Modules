<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\ForgetPassword;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use App\Services\OtpService;
use Illuminate\Support\Str;
use Mail;
use Illuminate\Support\Facades\Http;
use Closure;
use Exception;
use App\Exceptions\GlobalException;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * forgetPassword
     *
     * @return void
     */
    public function forgetPassword()
    {
        return view('auth.forgot_password');
    }
    
    /**
     * checkForgotPassword
     *
     * @param  mixed $request
     * @return void
     */
    public function checkForgotPassword(Request $request)
    {
        // $request->validate([
        //     'email_or_phone' => 'required',
        //     'g-recaptcha-response' => ['required',function (string $attribute, mixed $value, Closure $fail) {
        //         $g_response =Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify',[
        //             'secret' => config('services.recaptcha.secret_key'),
        //             'response' => $value,
        //             'remoteip' => \request()->ip()
        //         ]);
        //     //   check for captcha response
        //     //    dd($g_response->json());
        //     }],
        // ],
        // [
        //     'g-recaptcha-response:required'=>"Kindly check the captcha code you have entered."
        // ]);
        try {
            $user = User::where('mobile_number', $request->email_or_phone)->orWhere('email', $request->email_or_phone)->first();
            $apiMethod = in_array(config('constants.get_action.api'),$request->route()->getAction('middleware'));
            if($apiMethod){
                if (empty($user)) {                    
                    return response()->json([
                        'status' => 401,
                        'message' => "Email address or Phone  not found."
                    ],401);
                }else{
                    return response()->json([
                        'status' => 200,
                        'result' => $user,
                        'message' => "Choose From Below Option Reset Link on email Or get OTP on phpne"
                    ],200);
                }
            }else{
                if (empty($user)) {
                    return redirect()->route('auth.forgetPassword')->with('error', 'Email address or Phone  not found.');
                } else {
                    return view('auth.forgot_password', compact('user'));
                }
            }
        }catch (Exception $e) {
            DB::rollBack();
            throw new GlobalException($e->getMessage());
        }
    }

    /**
     * submitForgetPassword
     *
     * @return void
     */
    public function submitForgetPassword(Request $request)
    {
        try{
            $apiMethod = in_array(config('constants.get_action.api'),$request->route()->getAction('middleware'));
            if ($request->login_with_otp == 'reset_with_mobile_number') {
                $userCheck = User::where('mobile_number', $request->mobile_number)->first();
                if (!empty($userCheck)) {
                    $userDetail = [
                        'email' => $userCheck->email,
                        'mobile_number' => $userCheck->mobile_number,
                        'otp_type' => config('constants.otp_type.forgot_password'),
                        'userRole' => $userCheck->role,
                    ];
                    $userObject = (object) $userDetail;
                    OtpService::sendOtp($userObject);                    
                    if($apiMethod){
                        return response()->json([
                            'status' => 200,
                            'result' => $userDetail,
                            'message' => "OTP Send Successfull",
                        ],200);
                    }else{
                        // use for Blade template
                        dd($userDetail);
                    }
                }else{
                    if($apiMethod){
                        return response()->json([
                            'status' => 401,
                            'message' => "Phone Number Not Exist",
                        ],401);
                    }else{
                        // use for Blade template
                        die("Phone Number Not Exist");
                    }
                }
            } else {
                $user = User::where('email', $request->email)->first();                
                if (empty($user)) {
                    if($apiMethod){
                        return response()->json([
                            'status' => 401,
                            'message' => "Email Not Exist",
                        ],401);
                    }else{
                        // use for Blade template
                        die("email Not Exist");
                    }
                } else {                   
                    $token = Str::random(64);
                    DB::table('password_resets')->insert([
                        'email' => $request->email,
                        'token' => $token,
                        'created_at' => Carbon::now(),
                    ]);
                    // Mail::to($user->email)->send(new ForgetPassword($token));
                    $checkUser = User::whereEmail($request->email)->first();
                    if($apiMethod){
                        if (!empty($checkUser)) {
                            return response()->json([
                                'status' => 200,
                                'token' => $token,
                                'message' => "Email Send Successfull",
                            ],200);
                        }else{
                            return response()->json([
                                'status' => 401,
                                'message' => "Email Not Exist",
                            ],401);
                        }
                    }else{
                        // use for Blade template
                        if (!empty($checkUser)) {
                            return response()->json(200);
                        } else {
                            return response()->json(402);
                        }
                    }
                }
            }
        }catch (Exception $e) {
            DB::rollBack();
            throw new GlobalException($e->getMessage());
        }
    }
}
