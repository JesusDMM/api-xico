<?php

namespace App\Http\Controllers;

use App\Classes\ApiResponseClass;
use App\Interfaces\AuthRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Constants\Constants;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    private AuthRepositoryInterface $authRepository;

    public function __construct(
        AuthRepositoryInterface $authRepository
    ) {
        $this->authRepository = $authRepository;
    }

    public function getAnyHashPassword($password)
    {
        $data = [
            "hashed_password" => Hash::make($password)
        ];
        return ApiResponseClass::sendResponse(true, $data, "Hashed password");
    }

    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'nombre_usuario' => 'required|string|max:255|unique:usuarios,nombre_usuario',
            'contraseña' => 'required|string',
        ]);

        $validatedData['contraseña'] = Hash::make($validatedData['contraseña']);

        $user = $this->authRepository->register($validatedData);

        if (!$user) {
            return ApiResponseClass::sendResponse(false, null, Constants::USER_REGISTRATION_FAILED, 400);
        }

        return ApiResponseClass::sendResponse(true, $user->toArray(), Constants::USER_REGISTERED_SUCCESSFULLY, 201);
    }

    public function login(Request $request)
    {

        $credentials = $request->only('email', 'password');

        $token = JWTAuth::attempt($credentials);

        if (!$token) {
            return ApiResponseClass::sendResponse(
                false,
                null,
                Constants::INVALID_CREDENTIALS,
                400
            );
        }

        $user = auth()->user();

        // Refresh token data, delete if is unused
        $refreshToken = bin2hex(random_bytes(32));
        $hashedRefreshToken = Hash::make($refreshToken);
        $now = now()->addDays(14);
        $refreshTokenRequest = [
            'user_id' => $user->user_id,
            'refresh_token' => $hashedRefreshToken,
            'expires_at' => $now
        ];
        $refreshTokenData = $this->authRepository->createRefreshToken($refreshTokenRequest);
        if ($refreshTokenData == null) {
            return ApiResponseClass::sendResponse(
                false,
                null,
                Constants::REFRESH_TOKEN_ERROR,
                400
            );
        }

        if ($user->status === "inactive") {
            return ApiResponseClass::sendResponse(
                false,
                null,
                Constants::USER_INACTIVE,
                400
            );
        }

        return ApiResponseClass::sendResponse(
            true,
            [
                "user" => $user->toArray(),
                "access_token" => $token,
                "refresh_token" => $refreshToken
            ],
            Constants::LOGIN_SUCCESSFUL,
            200
        );
    }

    // Use it just if refresh token will be implemented
    public function refreshToken(Request $request)
    {
        $refreshToken = $request->input('refreshToken');
        // Search for the refresh token in the database
        $refreshTokenData = $this->authRepository->getRefreshTokenByUserId(auth()->id());
        if ($refreshTokenData->isEmpty()) {
            return ApiResponseClass::sendResponse(false, null, Constants::TOKEN_REFRESH_NOT_FOUND, 401);
        }

        foreach ($refreshTokenData as $data) {
            if (Hash::check($refreshToken, $data->refresh_token)) {

                // Check if the refresh token has expired
                if (now() > Carbon::parse($data->expires_at)) {
                    return ApiResponseClass::sendResponse(false, null, Constants::REFRESH_TOKEN_HAS_EXPIRE, 401);
                }

                $user = auth()->user();
                $newToken = JWTAuth::fromUser($user);
                $newTokenData = [
                    'access_token' => $newToken
                ];

                return ApiResponseClass::sendResponse(true, $newTokenData, Constants::TOKEN_REFRESHED);
            }
        }

        return ApiResponseClass::sendResponse(false, null, Constants::INVALID_TOKEN_REFRESH, 401);
    }

    // Use it just if refresh token will be implemented
    public function logout(Request $request)
    {
        // Delete the refresh token from the database
        $refreshToken = $request->input('refreshToken');
        $refreshTokenData = $this->authRepository->getRefreshTokenByUserId(auth()->id());
        if ($refreshTokenData->isEmpty()) {
            return ApiResponseClass::sendResponse(false, null, Constants::TOKEN_REFRESH_NOT_FOUND, 401);
        }
        // Check if the refresh token exists
        foreach ($refreshTokenData as $data) {
            if (Hash::check($refreshToken, $data->refresh_token)) {
                $this->authRepository->deleteRefreshToken($data->id);
                // Invalidate the JWT token
                JWTAuth::invalidate(JWTAuth::getToken());
                return ApiResponseClass::sendResponse(true, null, Constants::SUCCESSFULLY_LOGGED_OUT);
            }
        }

        return ApiResponseClass::sendResponse(false, null, Constants::INVALID_TOKEN_REFRESH, 401);
    }
}
