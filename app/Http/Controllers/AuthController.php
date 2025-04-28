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
        $credentials = $request->only('nombre_usuario', 'contraseña');

        // Buscar el usuario por nombre_usuario
        $user = $this->authRepository->findByUsername($credentials['nombre_usuario']);

        if (!$user || !Hash::check($credentials['contraseña'], $user->contraseña)) {
            return ApiResponseClass::sendResponse(
                false,
                null,
                Constants::INVALID_CREDENTIALS,
                400
            );
        }

        // Generar el token JWT
        $token = JWTAuth::fromUser($user);

        return ApiResponseClass::sendResponse(
            true,
            [
                "user" => $user->toArray(),
                "access_token" => $token
            ],
            Constants::LOGIN_SUCCESSFUL,
            200
        );
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
