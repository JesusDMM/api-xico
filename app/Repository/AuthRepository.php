<?php

namespace App\Repository;

use App\Interfaces\AuthRepositoryInterface;
use App\Models\RefreshToken;


class AuthRepository implements AuthRepositoryInterface
{
    public function register($request)
    {

    }
    public function login($request)
    {
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
}
