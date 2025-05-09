<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lote extends Model
{

    protected $table = 'lotes';

    protected $primaryKey = 'id';

    protected $keyType = 'string';

    public $incrementing = false;

    public $timestamps = true;

    protected $fillable = [
        'id',
        'producto_id',
        'tamaño_lote',
        'stock',
        'caducidad'
    ];
}
