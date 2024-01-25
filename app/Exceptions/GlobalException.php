<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Facades\Log;

class GlobalException extends Exception
{
    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request
     * @return \Illuminate\Http\Response
     */
    public function render($request, $responseType)
    {
        $clientIP = \Request::ip();
        $data = [
            'ip' => $clientIP,
            'file' => $this->getFile(),
            'line' => $this->getLine(),
            'message' => $this->getMessage(),
        ];
        Log::error($data);
        abort($this->getMessage());
        if ($responseType) {
            return response()->json(['status' => 'error', 'message' => $this->getMessage()], 500);
        }
    }
}
