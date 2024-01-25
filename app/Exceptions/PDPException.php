<?php

namespace App\Exceptions;

use Illuminate\Support\Facades\Log;
use Exception;

class PDPException extends Exception
{
    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request
     * 
     * @return \Illuminate\Http\Response
     */
    public function render($request)
    {
        // return response()->json([
        //     'error' => 'Unauthenticated',
        //     'message' => $this->getMessage(),
        // ], 404);
        $clientIP = \Request::ip();
        $data = [
            'ip' => $clientIP,
            'file'    => $this->getFile(),
            'line'    => $this->getLine(),
            'message' => $this->getMessage(),
        ];
        // print_r($data);
        // die;
        Log::error($data);
        return redirect()->back()->with('unsuccess', 'Opps Something wrong!');
    }
}
