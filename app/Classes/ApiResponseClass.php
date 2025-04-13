<?php

namespace App\Classes;

use App\Functions\CamelCaseFunction;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Log;

class ApiResponseClass
{
    public static function rollback($message)
    {
        DB::rollBack();
        self::throw($message);
    }

    public static function throw($message)
    {
        Log::info($message);
        $response = [
            'success' => false,
            'message' => $message,
            'data' => null
        ];
        throw new HttpResponseException(response()->json($response, 500));
    }

    public static function sendResponse($success, $data, $message, $code = 200)
    {
        $response = [
            'success' => $success,
            'message' => $message,
            'data' => CamelCaseFunction::convertKeysToCamelCase($data)
        ];


        return response()->json($response, $code);
    }

    public static function sendPDF($success, $data, $message, $code = 200)
    {
        $response = [
            'success' => $success,
            'message' => $message,
            'data' => $data
        ];


        return response()->json($response, $code);
    }
}
