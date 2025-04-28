<?php

namespace App\Repository;

use App\Models\EspecificacionIncidencia;
use App\Interfaces\EspecificacionIncidenciaRepositoryInterface;
use App\Models\Salida;

class EspecificacionIncidenciaRepository implements EspecificacionIncidenciaRepositoryInterface
{
    public function all()
    {
        return EspecificacionIncidencia::from('especificacion_incidencias as ei')
            ->select(
                'ei.id',
                'ei.salida_id',
                'ei.cantidad_defectuosos',
                'ei.causa',
                'ei.especificacion',
                'ei.destino',
                'u.nombre AS usuario_nombre',
                'p.nombre as nombre_producto',
                'p.presentacion',
                'p.categoria',
                'l.id as lote_id',
                'l.caducidad as lote_caducidad'
            )
            ->join('salidas as s', 's.id', '=', 'ei.salida_id')
            ->join('usuarios as u', 'u.id', '=', 's.usuario_id')
            ->join('lotes as l', 'l.id', '=', 's.lote_id')
            ->join('productos as p', 'p.id', '=', 'l.producto_id')
            ->orderBy('ei.id')
            ->get();
    }


    public function find($id)
    {
        return EspecificacionIncidencia::from('especificacion_incidencias as ei')
            ->select(
                'ei.id',
                'ei.salida_id',
                'ei.cantidad_defectuosos',
                'ei.causa',
                'ei.especificacion',
                'ei.destino',
                'u.nombre AS usuario_nombre',
                'p.nombre as nombre_producto',
                'p.presentacion',
                'p.categoria',
                'l.id as lote_id',
                'l.caducidad as lote_caducidad'
            )
            ->join('salidas as s', 's.id', '=', 'ei.salida_id')
            ->join('usuarios as u', 'u.id', '=', 's.usuario_id')
            ->join('lotes as l', 'l.id', '=', 's.lote_id')
            ->join('productos as p', 'p.id', '=', 'l.producto_id')
            ->where('ei.id', $id)
            ->first();
    }



    public function create(array $data)
    {
        $incidencia = EspecificacionIncidencia::create($data);

        return EspecificacionIncidencia::select(
            'id',
            'salida_id',
            'cantidad_defectuosos',
            'causa',
            'especificacion',
            'destino'
        )
            ->where('id', $incidencia->id)
            ->first();
    }


    public function update($id, array $data)
    {
        $incidencia = EspecificacionIncidencia::find($id);

        if (!$incidencia) {
            return null;
        }

        $incidencia->update($data);

        return EspecificacionIncidencia::select(
            'id',
            'salida_id',
            'cantidad_defectuosos',
            'causa',
            'especificacion',
            'destino'
        )
            ->where('id', $incidencia->id)
            ->first();
    }

    public function delete($id)
    {

        return EspecificacionIncidencia::destroy($id);
    }

    public function getByLoteId($loteId)
    {
        return EspecificacionIncidencia::from('especificacion_incidencias as ei')
            ->select(
                'ei.id',
                'ei.salida_id',
                'ei.cantidad_defectuosos',
                'ei.causa',
                'ei.especificacion',
                'ei.destino',
                'u.nombre AS usuario_nombre',
                'p.nombre as nombre_producto',
                'p.presentacion',
                'p.categoria',
                'l.id as lote_id',
                'l.caducidad as lote_caducidad'
            )
            ->join('salidas as s', 's.id', '=', 'ei.salida_id')
            ->join('usuarios as u', 'u.id', '=', 's.usuario_id')
            ->join('lotes as l', 'l.id', '=', 's.lote_id')
            ->join('productos as p', 'p.id', '=', 'l.producto_id')
            ->where('l.id', $loteId)
            ->first();
    }

    public function getBySalidaId($salidaId)
    {
        return EspecificacionIncidencia::from('especificacion_incidencias as ei')
            ->select(
                'ei.id',
                'ei.salida_id',
                'ei.cantidad_defectuosos',
                'ei.causa',
                'ei.especificacion',
                'ei.destino',
                'u.nombre AS usuario_nombre',
                'p.nombre as nombre_producto',
                'p.presentacion',
                'p.categoria',
                'l.id as lote_id',
                'l.caducidad as lote_caducidad'
            )
            ->join('salidas as s', 's.id', '=', 'ei.salida_id')
            ->join('usuarios as u', 'u.id', '=', 's.usuario_id')
            ->join('lotes as l', 'l.id', '=', 's.lote_id')
            ->join('productos as p', 'p.id', '=', 'l.producto_id')
            ->where('ei.salida_id', $salidaId)
            ->get();
    }
}
