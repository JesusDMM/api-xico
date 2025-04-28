<?php

namespace App\Interfaces;

interface AuthRepositoryInterface
{
    public function register($data);
    public function login($request);
    public function deleteRefreshToken(string $refreshToken);
    public function createRefreshToken($request);
    public function getRefreshTokenByUserId($userId);
    public function doesRefreshTokenExist(string $refreshToken);
}
