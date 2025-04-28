<?php

namespace App\Repository;

use App\Interfaces\AuthRepositoryInterface;
use App\Models\RefreshToken;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthRepository implements AuthRepositoryInterface
{
    public function register($data)
    {
        return User::create($data);
    }

    public function login($credentials)
    {
        return JWTAuth::attempt($credentials);
    }

    public function deleteRefreshToken($id)
    {
        return RefreshToken::where("id", $id)->delete();
    }

    public function createRefreshToken($request)
    {
        return RefreshToken::create($request);
    }

    public function getRefreshTokenByUserId($userId)
    {
        return RefreshToken::where('user_id', $userId)->get();
    }

    public function doesRefreshTokenExist($refreshToken)
    {
        return RefreshToken::where('refresh_token', $refreshToken)->first();
    }

    public function findByUsername($username)
    {
        return User::where('nombre_usuario', $username)->first();
    }
}
