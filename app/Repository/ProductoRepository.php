<?php

namespace App\Repository;

use App\Models\Producto;
use App\Interfaces\ProductoRepositoryInterface;

class ProductoRepository implements ProductoRepositoryInterface
{
    public function getIdAndNombre()
    {
        return Producto::select('id', 'nombre')->get();
    }

    public function getIdNombrePresentacionCategoria()
    {
        return Producto::select('id', 'nombre', 'presentacion', 'categoria')->get();
    }

    public function getByCategoria($categoria)
    {
        return Producto::select('id', 'nombre')
            ->where('categoria', $categoria)
            ->get();
    }

    public function getCategoriasUnicas()
    {
        return Producto::select('categoria')->distinct()->pluck('categoria');
    }
}
