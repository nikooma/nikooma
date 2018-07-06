<?php

namespace App\Http\Controllers;


class DateTimeConverter extends Controller
{
    public static function ConvertGeorgianToLocal($gdatetime){
        return $gdatetime;
    }
    public static function ConvertLocalToGeorgian($ldatetime){
        return $ldatetime;
    }
}
