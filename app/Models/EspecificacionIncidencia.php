<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EspecificacionIncidencia extends Model
{
    protected $table = 'especificacion_incidencias';

    protected $primaryKey = 'id';

    public $incrementing = true;

    public $timestamps = true;

    protected $fillable = [
        'salida_id',
        'cantidad_defectuosos',
        'causa',
        'especificacion'
    ];
}
