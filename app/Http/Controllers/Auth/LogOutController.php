<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Session;

class LogOutController extends Controller
{  
    /**
     * logout
     *
     * @return void
     */
    public function logout(){
        auth()->user()->tokens()->delete();
        return response()->json([
          "message"=>"logged out"
        ]);
    }
}
