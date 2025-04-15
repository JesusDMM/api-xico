<?php

namespace App\Repository;

use App\Models\EspecificacionIncidencia;
use App\Interfaces\EspecificacionIncidenciaRepositoryInterface;
use App\Models\Salida;

class EspecificacionIncidenciaRepository implements EspecificacionIncidenciaRepositoryInterface
{
    public function all()
    {
        return EspecificacionIncidencia::join('salidas', 'salidas.id', '=', 'especificacion_incidencias.salida_id')
            ->select(
                'especificacion_incidencias.id',
                'especificacion_incidencias.salida_id',
                'especificacion_incidencias.cantidad_defectuosos',
                'especificacion_incidencias.causa',
                'especificacion_incidencias.especificacion'
            )
            ->get();
    }

    public function find($id)
    {
        return EspecificacionIncidencia::join('salidas', 'salidas.id', '=', 'especificacion_incidencias.salida_id')
            ->select(
                'especificacion_incidencias.id',
                'especificacion_incidencias.salida_id',
                'especificacion_incidencias.cantidad_defectuosos',
                'especificacion_incidencias.causa',
                'especificacion_incidencias.especificacion'
            )
            ->where('especificacion_incidencias.id', $id)
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
        return EspecificacionIncidencia::join('salidas', 'salidas.id', '=', 'especificacion_incidencias.salida_id')
            ->where('salidas.lote_id', $loteId)
            ->select(
                'especificacion_incidencias.id',
                'especificacion_incidencias.salida_id',
                'especificacion_incidencias.cantidad_defectuosos',
                'especificacion_incidencias.causa',
                'especificacion_incidencias.especificacion'
            )
            ->get();
    }
}
