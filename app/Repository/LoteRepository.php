<?php

namespace App\Repository;

use App\Models\Lote;
use App\Interfaces\LoteRepositoryInterface;

class LoteRepository implements LoteRepositoryInterface
{
    public function all()
    {
        return Lote::select('id', 'tipo_producto', 'tamaño_lote', 'stock', 'caducidad')->get();
    }

    public function find($id)
    {
        return Lote::select('id', 'tipo_producto', 'tamaño_lote', 'stock', 'caducidad')->find($id);
    }

    public function ExistsById($id)
    {
        return Lote::where('id', $id)->exists();
    }

    public function create(array $data)
    {
        $lote = Lote::create($data);
        return Lote::select('id', 'tipo_producto', 'tamaño_lote', 'stock', 'caducidad')->find($lote->id);
    }

    public function update($id, array $data)
    {
        $lote = Lote::find($id);

        $tamañoOriginal = $lote->tamaño_lote;
        $nuevoTamaño = $data['tamaño_lote'];

        $tamañoFinal = $nuevoTamaño - $tamañoOriginal;
        $nuevoStock = $lote->stock + $tamañoFinal;

        if ($nuevoStock < 0) {
            return null;
        }

        $lote->tipo_producto = $data['tipo_producto'];
        $lote->tamaño_lote = $nuevoTamaño;
        $lote->caducidad = $data['caducidad'];
        $lote->stock = $nuevoStock;

        $lote->save();

        return $lote;
    }


    public function delete($id)
    {
        return Lote::destroy($id);
    }
}
