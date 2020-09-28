<?php


namespace App\Util;


class myResponse
{
    public static function apiResponse($data = [], $message = "")
    {
        return ["data" => $data, "message" => $message];
    }
}
