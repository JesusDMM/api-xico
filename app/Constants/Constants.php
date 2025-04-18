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

    const ERROR = 'Ocurrió un error inesperado';

    //Lotes
    const LOTE_CREATED = 'Lote creado correctamente';
    const LOTE_UPDATED = 'Lote actualizado correctamente';
    const LOTE_DELETED = 'Lote eliminado correctamente';
    const LOTE_CREATE_ERROR = 'Error al crear el lote';
    const LOTE_ID_DUPLICADO = 'El ID del lote ya existe';
    const LOTE_NOT_FOUND = 'Lote no encontrado';
    const LOTES_LISTED = 'Lotes obtenidos correctamente';
    const LOTE_DETAIL = 'Detalle del lote obtenido correctamente';


    const LOTE_UPDATE_ERROR = 'Error al actualizar el lote';
    const LOTE_DELETE_ERROR = 'Error al eliminar el lote';
    const LOTE_VALIDATION_ERROR = 'Los datos proporcionados para el lote no son válidos';
    const LOTE_UPDATE_INVALID_STOCK = 'No se puede reducir el tamaño del lote porque el stock resultante sería negativo.';
}
