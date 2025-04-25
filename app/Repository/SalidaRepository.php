<?php

namespace App\Repository;

use App\Models\Salida;
use App\Interfaces\SalidaRepositoryInterface;

class SalidaRepository implements SalidaRepositoryInterface
{
    public function all()
    {
        return Salida::join('usuarios', 'salidas.usuario_id', '=', 'usuarios.id')
            ->join('lotes', 'salidas.lote_id', '=', 'lotes.id')
            ->join('productos', 'lotes.producto_id', '=', 'productos.id')
            ->select(
                'salidas.id AS salida_id',
                'salidas.cantidad',
                'salidas.created_at AS salida_fecha',
                'usuarios.nombre AS usuario_nombre',
                'productos.nombre AS producto_nombre',
                'productos.presentacion AS producto_presentacion',
                'lotes.stock AS producto_stock',
                'lotes.caducidad as lote_caducidad',
                'lotes.id AS lote_id'
            )
            ->get();
    }

    public function find($id)
    {
        return Salida::select(
            'salidas.id AS salida_id',
            'salidas.cantidad',
            'salidas.created_at AS salida_fecha',
            'usuarios.nombre AS usuario_nombre',
            'productos.nombre AS producto_nombre',
            'productos.presentacion AS producto_presentacion',
            'lotes.stock AS producto_stock',
            'lotes.caducidad as lote_caducidad',
            'lotes.id AS lote_id'
        )
            ->join('usuarios', 'salidas.usuario_id', '=', 'usuarios.id')
            ->join('lotes', 'salidas.lote_id', '=', 'lotes.id')
            ->join('productos', 'lotes.producto_id', '=', 'productos.id')
            ->where('salidas.lote_id', $id)
            ->get();
    }

    public function ExistsById($id)
    {
        return Salida::where('id', $id)->exists();
    }

    public function findById($id)
    {
        return Salida::find($id);
    }


    public function create(array $data)
    {

        $salida = Salida::create($data);

        return Salida::select(
            'salidas.id AS salida_id',
            'salidas.cantidad',
            'salidas.created_at AS salida_fecha',
            'usuarios.nombre AS usuario_nombre',
            'productos.nombre AS producto_nombre',
            'productos.presentacion AS producto_presentacion',
            'lotes.stock AS producto_stock',
            'lotes.caducidad as lote_caducidad',
            'lotes.id AS lote_id'
        )
            ->join('usuarios', 'salidas.usuario_id', '=', 'usuarios.id')
            ->join('lotes', 'salidas.lote_id', '=', 'lotes.id')
            ->join('productos', 'lotes.producto_id', '=', 'productos.id')
            ->where('salidas.id', $salida->id)
            ->first();
    }

    public function update($id, array $data)
    {
        $salida = Salida::find($id);

        if (!$salida) {
            return null;
        }

        $salida->update($data);

        return Salida::select(
            'salidas.id AS salida_id',
            'salidas.cantidad',
            'salidas.created_at AS salida_fecha',
            'usuarios.nombre AS usuario_nombre',
            'productos.nombre AS producto_nombre',
            'productos.presentacion AS producto_presentacion',
            'lotes.stock AS producto_stock',
            'lotes.caducidad as lote_caducidad',
            'lotes.id AS lote_id'
        )
            ->join('usuarios', 'salidas.usuario_id', '=', 'usuarios.id')
            ->join('lotes', 'salidas.lote_id', '=', 'lotes.id')
            ->join('productos', 'lotes.producto_id', '=', 'productos.id')
            ->where('salidas.id', $salida->id)
            ->first();
    }

    public function delete($id)
    {
        return Salida::destroy($id);
    }
}
