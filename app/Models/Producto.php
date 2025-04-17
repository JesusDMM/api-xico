<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'productos';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $fillable = [
        'nombre',
        'presentacion',
        'categoria'
    ];

    public $timestamps = false;
}
