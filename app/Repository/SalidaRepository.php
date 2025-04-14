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
            ->select('salidas.id AS salida_id', 'salidas.cantidad', 'usuarios.nombre AS usuario_nombre', 'lotes.tipo_producto AS producto_lote', 'lotes.id AS lote_id')
            ->get();
    }

    public function find($id)
    {
        return Salida::join('usuarios', 'salidas.usuario_id', '=', 'usuarios.id')
            ->join('lotes', 'salidas.lote_id', '=', 'lotes.id')
            ->where('salidas.lote_id', $id)
            ->select(
                'salidas.id AS salida_id',
                'salidas.cantidad',
                'usuarios.nombre AS usuario_nombre',
                'lotes.tipo_producto AS producto_lote',
                'lotes.id AS lote_id'
            )
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

        return Salida::join('lotes', 'salidas.lote_id', '=', 'lotes.id')
            ->join('usuarios', 'salidas.usuario_id', '=', 'usuarios.id')
            ->select(
                'salidas.id',
                'salidas.lote_id',
                'salidas.cantidad',
                'salidas.usuario_id',
                'lotes.tipo_producto',
                'usuarios.nombre as usuario_nombre'
            )
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

        return Salida::join('usuarios', 'salidas.usuario_id', '=', 'usuarios.id')
            ->join('lotes', 'salidas.lote_id', '=', 'lotes.id')
            ->where('salidas.id', $salida->id)
            ->select(
                'salidas.id AS salida_id',
                'salidas.cantidad',
                'usuarios.nombre AS usuario_nombre',
                'lotes.tipo_producto AS producto_lote',
                'lotes.id AS lote_id'
            )
            ->first();
    }

    public function delete($id)
    {
        return Salida::destroy($id);
    }
}
