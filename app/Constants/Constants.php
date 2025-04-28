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
    public const USER_REGISTERED_SUCCESSFULLY = 'Usuario registrado exitosamente';
    public const USER_REGISTRATION_FAILED = 'Error al registrar el usuario';
    public const USER_NOT_FOUND = 'Usuario no encontrado';

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

    // Salidas
    const SALIDA_NOT_FOUND = 'Salida no encontrada';
    const SALIDA_NOT_AVAILABLE = 'No hay suficiente stock para esta salida';
    const SALIDA_CREATE_ERROR = 'Error al crear la salida';
    const SALIDA_CREATED = 'Salida creada con éxito';
    const SALIDA_UPDATE_ERROR = 'Error al actualizar la salida';
    const SALIDA_UPDATED = 'Salida actualizada con éxito';
    const SALIDA_DELETED = 'Salida eliminada con éxito';
    const SALIDA_DELETED_ERROR = 'Error al eliminar la salida';
    const SALIDA_NO_STOCK_AVAILABLE = 'No hay suficiente stock disponible para actualizar la salida.';
    const SALIDAS_NOT_FOUND = 'No se encontraron salidas para el lote especificado';

    // Incidencia
    const INCIDENCIA_CREATED = 'Incidencia creada con éxito';
    const INCIDENCIA_CREATE_ERROR = 'Hubo un error al crear la incidencia';
    const INCIDENCIA_UPDATE_ERROR = 'Hubo un error al actualizar la incidencia';
    const INCIDENCIA_UPDATED = 'Incidencia actualizada con éxito';
    const INCIDENCIA_DELETED = 'Incidencia eliminada con éxito';
    const INCIDENCIA_DELETE_ERROR = 'Error al eliminar una incidencia.';
    const INCIDENCIA_NOT_FOUND = 'Incidencia no encontrada';
    const INCIDENCIA_NO_STOCK_AVAILABLE = 'No hay suficiente stock disponible para la incidencia';
    const INCIDENCIAS_NOT_FOUND = 'No se encontraron incidencias para la salida especificada';
}
