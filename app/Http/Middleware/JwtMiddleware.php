<?php

namespace App\Http\Middleware;

use App\Classes\ApiResponseClass;
use App\Constants\Constants;
use Closure;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class JwtMiddleware
{
    public function handle($request, Closure $next)
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (JWTException $e) {
            if ($e instanceof TokenInvalidException) {
                return ApiResponseClass::sendResponse(false, ["error_message" => $e->getMessage()], Constants::INVALID_ACCESS_TOKEN, 401);
            }

            if ($e instanceof TokenExpiredException) {
                return ApiResponseClass::sendResponse(false, ["error_message" => $e->getMessage()], Constants::ACCESS_TOKEN_HAS_EXPIRE, 401);
            }

            return ApiResponseClass::sendResponse(false, ["error_message" => $e->getMessage()], Constants::ACCESS_TOKEN_HAS_NOT_BEEN_FOUND, 401);
        }

        return $next($request);
    }
}
