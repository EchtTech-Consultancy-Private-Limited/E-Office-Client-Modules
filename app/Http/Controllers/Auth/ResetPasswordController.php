<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Jobseeker;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Closure;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    // protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * ResetPassword
     *
     * @param  mixed  $token
     * @return void
     */
    public function resetPassword($token)
    {
        return view('auth.reset_password', ['token' => $token]);
    }

    /**
     * submitResetPasswordForm
     *
     * @param  mixed  $request
     * @return void
     */
    public function submitResetPasswordForm(Request $request)
    {
        $request->validate([
            'password' => 'required',
        ]);
        $apiMethod = in_array(config('constants.get_action.api'),$request->route()->getAction('middleware'));
        $check = DB::table('password_resets')->where('token', $request->token)->first();
        if (!$check) {
            if($apiMethod){
                return response()->json(['status' => 401,'message' => "Invalid token!"], 401);
            }else{
                return redirect()->back()->with('error', 'Invalid token!');
            }
        }
        DB::table('password_resets')
            ->where([
                'email' => $check->email,
                'token' => $request->token,
            ])
            ->first();
        User::where('email', $check->email)->orWhere('mobile_number', $check->email)
            ->update(['password' => Hash::make($request->password)]);
        User::where('email', $check->email)->orWhere('mobile_number', $check->email)
            ->update(['otp_status' => '0']);
        DB::table('password_resets')->where(['email' => $check->email])->delete();
        $checkUser = User::where('mobile_number', $check->email)->orWhere('email', $check->email)->first();
        if($apiMethod){
            if(!empty($checkUser)){
                return response()->json(['status' => 200,'message' => "Your password has been changed!"], 200);
            }
        }else{
            if (!empty($checkUser)) {
                return redirect('/')->with('success', 'Your password has been changed!');
            }
        }
        
    }

    /**
     * changePassword
     *
     * @return void
     */
    public function changePassword()
    {
        return view('auth.change_password');
    }

    public function changePasswordSubmit(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Current password does not match!');
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Password successfully changed!');
    }
}
