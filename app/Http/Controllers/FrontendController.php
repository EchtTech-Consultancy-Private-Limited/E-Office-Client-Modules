<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FrontendController extends Controller
{    
    /**
     *  @index page
     *
     * @return void
     */
    public function index()
    {
        return view('auth.login');
    }
}
