<?php

namespace App\Constants;

class Constants
{
    public const SUCCESS = 'success';
    public const FAILED = 'failed';

    // TOKENS
    public const TOKEN_REFRESH_NOT_FOUND = 'El token refresh no ha sido encontrado';
    public const TOKEN_REFRESHED = 'El token ha sido actualizado';
    public const INVALID_TOKEN_REFRESH = 'El token refresh es invalido';
    public const SUCCESSFULLY_LOGGED_OUT = 'El usuario se ha deslogueado correctamente';
    public const REFRESH_TOKEN_ERROR = 'Ha ocurrido un error al crear el refresh token';
    public const INVALID_ACCESS_TOKEN = 'El token de acceso es invalido';
    public const ACCESS_TOKEN_HAS_EXPIRE = 'El token de acceso ha expirado';
    public const ACCESS_TOKEN_HAS_NOT_BEEN_FOUND = 'El token de acceso no ha sido encontrado';
    public const REFRESH_TOKEN_HAS_EXPIRE = 'El refresh token ha expirado';

    // Auth
    public const INVALID_CREDENTIALS = 'Credenciales invalidas';
    public const USER_INACTIVE = 'El usuario se encuentra inactivo';
    public const LOGIN_SUCCESSFUL = 'El usuario se ha logueado correctamente';
}
