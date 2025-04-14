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

    public function decreaseStock(Lote $lote, $cantidad)
    {
        if ($lote->stock >= $cantidad) {
            $lote->stock -= $cantidad;
            $lote->save();
        } else {
            return null;
        }
    }

    public function increaseStock(Lote $lote, $cantidad)
    {
        $lote->stock += $cantidad;
        $lote->save();
        return $lote;
    }

    public function ajustarStockPorActualizacion(Lote $lote, int $cantidadAnterior, int $nuevaCantidad): bool
    {
        $diferencia = $nuevaCantidad - $cantidadAnterior;

        if ($diferencia === 0) {
            return true;
        }

        if ($diferencia < 0) {
            $lote->stock += abs($diferencia);
            $lote->save();
            return true;
        }

        if ($lote->stock >= $diferencia) {
            $lote->stock -= $diferencia;
            $lote->save();
            return true;
        }

        return false;
    }
}
