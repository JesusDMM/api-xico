<?php

namespace App\Repository;

use App\Models\Lote;
use App\Interfaces\LoteRepositoryInterface;
use Illuminate\Support\Facades\DB;

class LoteRepository implements LoteRepositoryInterface
{
    public function all()
    {
        return Lote::select('id', 'producto_id', 'tamaño_lote', 'stock', 'caducidad')->get();
    }

    public function find($id)
    {
        return Lote::select('id', 'producto_id', 'tamaño_lote', 'stock', 'caducidad')->find($id);
    }

    public function ExistsById($id)
    {
        return Lote::where('id', $id)->exists();
    }

    public function create(array $data)
    {
        $lote = Lote::create($data);
        return Lote::select('id', 'producto_id', 'tamaño_lote', 'stock', 'caducidad')->find($lote->id);
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

        $lote->producto_id = $data['producto_id'];
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

    public function getAllLotesConSalidasYIncidencias()
    {
        $lotes = DB::table('lotes')
            ->join('productos', 'lotes.producto_id', '=', 'productos.id')
            ->select(
                'lotes.id as loteId',
                'productos.nombre as productoLote',
                'lotes.tamaño_lote as tamañoLote',
                'lotes.stock',
                'lotes.caducidad',
                DB::raw("(
                SELECT JSON_ARRAYAGG(
                    JSON_OBJECT(
                        'salidaId', salidas.id,
                        'cantidad', salidas.cantidad,
                        'usuarioNombre', usuarios.nombre,
                        'incidencias', (
                            SELECT JSON_ARRAYAGG(
                                JSON_OBJECT(
                                    'cantidad_defectuosos', ei.cantidad_defectuosos,
                                    'causa', ei.causa,
                                    'especificacion', ei.especificacion,
                                    'destino', ei.destino
                                )
                            )
                            FROM especificacion_incidencias ei
                            WHERE ei.salida_id = salidas.id
                        )
                    )
                )
                FROM salidas
                INNER JOIN usuarios ON salidas.usuario_id = usuarios.id
                WHERE salidas.lote_id = lotes.id
            ) as salidas")
            )
            ->get()
            ->map(function ($lote) {
                $lote->salidas = json_decode($lote->salidas, true);
                return $lote;
            });

        return $lotes;
    }

    public function getLoteConSalidasYIncidencias($loteId)
    {
        $lotes = DB::table('lotes')
            ->join('productos', 'lotes.producto_id', '=', 'productos.id')
            ->where('lotes.id', $loteId)
            ->select(
                'lotes.id as loteId',
                'productos.nombre as productoLote',
                'lotes.tamaño_lote as tamañoLote',
                'lotes.stock',
                'lotes.caducidad',
                DB::raw("(
                SELECT JSON_ARRAYAGG(
                    JSON_OBJECT(
                        'salidaId', salidas.id,
                        'cantidad', salidas.cantidad,
                        'usuarioNombre', usuarios.nombre,
                        'incidencias', (
                            SELECT JSON_ARRAYAGG(
                                JSON_OBJECT(
                                    'cantidad_defectuosos', ei.cantidad_defectuosos,
                                    'causa', ei.causa,
                                    'especificacion', ei.especificacion,
                                    'destino', ei.destino
                                )
                            )
                            FROM especificacion_incidencias ei
                            WHERE ei.salida_id = salidas.id
                        )
                    )
                )
                FROM salidas
                INNER JOIN usuarios ON salidas.usuario_id = usuarios.id
                WHERE salidas.lote_id = lotes.id
            ) as salidas")
            )
            ->get()
            ->map(function ($lote) {
                $lote->salidas = json_decode($lote->salidas, true);
                return $lote;
            });

        return $lotes;
    }
}
