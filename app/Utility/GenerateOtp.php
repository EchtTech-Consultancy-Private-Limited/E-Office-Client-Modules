<?php

namespace App\Utility;

class GenerateOtp
{
    public static function otpGenerate($length)
    {
        return rand(
            ((int) str_pad(1, $length, 0, STR_PAD_RIGHT)),
            ((int) str_pad(9, $length, 9, STR_PAD_RIGHT))
        );
    }
}
