<?php

namespace App\Http\Controllers;

use App\Interfaces\EspecificacionIncidenciaRepositoryInterface;
use App\Interfaces\LoteRepositoryInterface;
use App\Interfaces\SalidaRepositoryInterface;
use App\Classes\ApiResponseClass;
use App\Constants\Constants;
use Illuminate\Http\Request;

class EspecificacionIncidenciaController extends Controller
{

    protected $loteRepo;
    protected $salidaRepo;
    protected $repo;

    public function __construct(LoteRepositoryInterface $loteRepo, SalidaRepositoryInterface $salidaRepo, EspecificacionIncidenciaRepositoryInterface $repo)
    {
        $this->loteRepo = $loteRepo;
        $this->salidaRepo = $salidaRepo;
        $this->repo = $repo;
    }

    public function index()
    {
        $incidencias = $this->repo->all();
        return ApiResponseClass::sendResponse(true, $incidencias->toArray(), Constants::SUCCESS);
    }

    public function show($id)
    {
        $incidencia = $this->repo->find($id);

        if (!$incidencia) {
            return ApiResponseClass::sendResponse(false, null, Constants::INCIDENCIA_NOT_FOUND, 404);
        }

        return ApiResponseClass::sendResponse(true, $incidencia->toArray(), Constants::SUCCESS);
    }

    public function store(Request $request)
    {
        $request->validate([
            'salida_id' => 'required|integer',
            'cantidad_defectuosos' => 'required|integer|min:1',
            'causa' => 'required|string',
            'especificacion' => 'nullable|string',
            'destino' => 'required|string|in:Reproceso,Reempacado,Desperdicio'
        ]);

        $data = $request->all();

        $salida = $this->salidaRepo->findById($data['salida_id']);

        if (!$salida) {
            return ApiResponseClass::sendResponse(false, null, Constants::SALIDA_NOT_FOUND, 404);
        }

        $lote = $this->loteRepo->find($salida->lote_id);

        if (!$lote) {
            return ApiResponseClass::sendResponse(false, null, Constants::LOTE_NOT_FOUND, 400);
        }

        if ($lote->stock < $data['cantidad_defectuosos']) {
            return ApiResponseClass::sendResponse(false, null, Constants::SALIDA_NOT_AVAILABLE, 400);
        }

        $this->loteRepo->decreaseStock($lote, $data['cantidad_defectuosos']);

        $incidencia = $this->repo->create($data);

        if (!$incidencia) {
            return ApiResponseClass::sendResponse(false, null, Constants::INCIDENCIA_CREATE_ERROR, 500);
        }

        return ApiResponseClass::sendResponse(true, $incidencia->toArray(), Constants::INCIDENCIA_CREATED, 201);
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'cantidad_defectuosos' => 'required|integer',
                'causa' => 'required|string',
                'especificacion' => 'nullable|string',
                'destino' => 'required|string|in:Reproceso,Reempacado,Desperdicio'
            ]);

            $incidencia = $this->repo->find($id);

            if (!$incidencia) {
                return ApiResponseClass::sendResponse(false, null, Constants::INCIDENCIA_NOT_FOUND, 404);
            }

            $salida = $this->salidaRepo->findById($incidencia->salida_id);
            if (!$salida) {
                return ApiResponseClass::sendResponse(false, null, Constants::SALIDA_NOT_FOUND, 404);
            }

            $lote = $this->loteRepo->find($salida->lote_id);
            if (!$lote) {
                return ApiResponseClass::sendResponse(false, null, Constants::LOTE_NOT_FOUND, 404);
            }

            $cantidadAnterior = $incidencia->cantidad_defectuosos;
            $nuevaCantidad = $request->cantidad_defectuosos;

            $ok = $this->loteRepo->ajustarStockPorActualizacion($lote, $cantidadAnterior, $nuevaCantidad);
            if (!$ok) {
                return ApiResponseClass::sendResponse(false, null, Constants::SALIDA_NO_STOCK_AVAILABLE, 400);
            }

            $data = $request->all();
            $incidenciaActualizada = $this->repo->update($id, $data);

            if (!$incidenciaActualizada) {
                return ApiResponseClass::sendResponse(false, null, Constants::INCIDENCIA_UPDATE_ERROR, 500);
            }

            return ApiResponseClass::sendResponse(true, $incidenciaActualizada->toArray(), Constants::INCIDENCIA_UPDATED);
        } catch (\Throwable $e) {
            return ApiResponseClass::throw($e->getMessage());
        }
    }


    public function destroy($id)
    {
        try {
            $incidencia = $this->repo->find($id);

            if (!$incidencia) {
                return ApiResponseClass::sendResponse(false, null, Constants::INCIDENCIA_NOT_FOUND, 404);
            }

            $salida = $this->salidaRepo->findById($incidencia->salida_id);
            if (!$salida) {
                return ApiResponseClass::sendResponse(false, null, Constants::SALIDA_NOT_FOUND, 404);
            }

            $lote = $this->loteRepo->find($salida->lote_id);
            if (!$lote) {
                return ApiResponseClass::sendResponse(false, null, Constants::LOTE_NOT_FOUND, 404);
            }

            $this->loteRepo->increaseStock($lote, $incidencia->cantidad_defectuosos);

            $deleted = $this->repo->delete($id);

            if (!$deleted) {
                return ApiResponseClass::sendResponse(false, null, Constants::INCIDENCIA_DELETE_ERROR, 500);
            }

            return ApiResponseClass::sendResponse(true, null, Constants::INCIDENCIA_DELETED);
        } catch (\Throwable $e) {
            return ApiResponseClass::throw($e->getMessage());
        }
    }


    public function getByLoteId($loteId)
    {
        $lote = $this->loteRepo->find($loteId);

        if (!$lote) {
            return ApiResponseClass::sendResponse(false, null, Constants::LOTE_NOT_FOUND, 400);
        }

        $incidencias = $this->repo->getByLoteId($loteId);
        return ApiResponseClass::sendResponse(true, $incidencias->toArray(), Constants::SUCCESS);
    }

    public function getBySalidaId($salidaId)
    {
        $salida = $this->salidaRepo->findById($salidaId);

        if (!$salida) {
            return ApiResponseClass::sendResponse(false, null, Constants::SALIDA_NOT_FOUND, 404);
        }

        $incidencias = $this->repo->getBySalidaId($salidaId);

        if ($incidencias->isEmpty()) {
            return ApiResponseClass::sendResponse(false, null, Constants::INCIDENCIAS_NOT_FOUND, 404);
        }

        return ApiResponseClass::sendResponse(true, $incidencias->toArray(), Constants::SUCCESS);
    }
}
