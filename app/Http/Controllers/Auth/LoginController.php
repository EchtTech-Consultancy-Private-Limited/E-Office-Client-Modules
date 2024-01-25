<?php

namespace App\Http\Controllers\Auth;

use Mews\Captcha\Facades\Captcha;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\OtpService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Closure;

use function Laravel\Prompts\password;

class LoginController extends Controller
{
    /**
     * login
     *
     * @return void
     */
    public function index()
    {
        return view('auth.login');
    }

    /**
     * empCheck
     *
     * @param  mixed  $request
     * @return void
     */
    public function login(Request $request)
    {
        // $request->validate([
        //     'captcha' => ['required',function (string $attribute, mixed $value, Closure $fail) {
        //         $g_response =Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify',[
        //             'secret' => config('services.recaptcha.secret_key'),
        //             'response' => $value,
        //             'remoteip' => \request()->ip()
        //         ]);
        //     //    check for captcha response
        //     //    dd($g_response->json());
        //     }],
        // ],
        // [
        //     'captcha:required'=>"Kindly check the captcha code you have entered."
        // ]);
        // $request->validate([
        //     'user_name' => 'required',
        // ]);
        $userCheck = User::where('user_name', $request->user_name)->first();
        if ($request->login_type == 'login_with_password') {
            if (Auth::attempt(['mobile_number' => $request->mobile_number, 'password' => $request->password, 'role' => $request->user_role, 'otp_status' => '1'])) {
                User::whereMobileNumber($request->mobile_number)
                ->update(['otp_status' => '0']);
                $user = Auth::user(); 
                $token =  $user->createToken($user->name.'-AuthToken')->plainTextToken;
                return response()->json(['status' => 200,'message' => 'Login successfull','token' => $token], 200);
            }else{
                return response()->json(['status' => 201,'message' => 'Invalid Credencial !'], 201);
            }
        }
        if ($request->login_type == 'login_with_otp') {
            if (!empty($userCheck)) {
                if ($userCheck->user_name == $request->user_name) {
                    $userDetail = [
                        'email' => $userCheck->email,
                        'mobile_number' => $userCheck->mobile_number,
                        'user_name' => $userCheck->user_name,
                        'otp_type' => config('constants.otp_type.login'),
                        'userRole' => $userCheck->role,
                    ];
                    $userObject = (object) $userDetail;
                    OtpService::sendOtp($userObject);
                    return response()->json(['status' => 200, 'result' => $userDetail,'message' => "Otp send on your mobile number and email"], 200);
                }
            }
            return response()->json(['status' => 201, 'result' => "Invalid User Name"], 201);
        }
        return response()->json(['status' => 401, 'result' => "Oops Somethings went wrong!"], 200);
    }
}
