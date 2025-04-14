<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\SalidaRepositoryInterface;
use App\Interfaces\LoteRepositoryInterface;
use App\Classes\ApiResponseClass;
use App\Constants\Constants;

class SalidaController extends Controller
{
    protected $loteRepo;
    protected $salidaRepo;

    public function __construct(LoteRepositoryInterface $loteRepo, SalidaRepositoryInterface $salidaRepo)
    {
        $this->loteRepo = $loteRepo;
        $this->salidaRepo = $salidaRepo;
    }

    public function index()
    {
        $salidas = $this->salidaRepo->all();
        return ApiResponseClass::sendResponse(true, $salidas->toArray(), Constants::SUCCESS);
    }

    public function show($id)
    {
        $loteExists = $this->loteRepo->ExistsById($id);

        if (!$loteExists) {
            return ApiResponseClass::sendResponse(false, null, Constants::LOTE_NOT_FOUND, 404);
        }

        $salida = $this->salidaRepo->find($id);

        if (!$salida) {
            return ApiResponseClass::sendResponse(false, null, Constants::FAILED, 404);
        }

        return ApiResponseClass::sendResponse(true, $salida->toArray(), Constants::SUCCESS);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'lote_id' => 'required|string|max:255',
                'cantidad' => 'required|integer|min:1',
                'usuario_id' => 'required|integer',
            ]);

            $data = $request->all();

            $lote = $this->loteRepo->find($data['lote_id']);

            if (!$lote || $lote->stock < $data['cantidad']) {
                return ApiResponseClass::sendResponse(false, null, Constants::SALIDA_CREATE_ERROR, 400);
            }

            $this->loteRepo->decreaseStock($lote, $data['cantidad']);

            $salida = $this->salidaRepo->create($data);

            if (!$salida) {
                return ApiResponseClass::sendResponse(false, null, Constants::SALIDA_CREATE_ERROR, 500);
            }

            return ApiResponseClass::sendResponse(true, $salida->toArray(), Constants::SALIDA_CREATED, 201);
        } catch (\Throwable $e) {
            return ApiResponseClass::throw($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'lote_id' => 'required|string|max:255',
                'cantidad' => 'required|integer|min:1',
                'usuario_id' => 'required|integer',
            ]);

            $salida = $this->salidaRepo->findById($id);

            if (!$salida) {
                return ApiResponseClass::sendResponse(false, null, Constants::SALIDA_NOT_FOUND, 404);
            }

            $lote = $this->loteRepo->find($request->lote_id);
            if (!$lote) {
                return ApiResponseClass::sendResponse(false, null, Constants::LOTE_NOT_FOUND, 404);
            }

            $ok = $this->loteRepo->ajustarStockPorActualizacion($lote, $salida->cantidad, $request->cantidad);
            if (!$ok) {
                return ApiResponseClass::sendResponse(false, null, Constants::SALIDA_NO_STOCK_AVAILABLE, 400);
            }

            $updated = $this->salidaRepo->update($id, $request->all());
            if (!$updated) {
                return ApiResponseClass::sendResponse(false, null, Constants::SALIDA_UPDATE_ERROR, 500);
            }

            return ApiResponseClass::sendResponse(true, $updated->toArray(), Constants::SALIDA_UPDATED);
        } catch (\Throwable $e) {
            return ApiResponseClass::throw($e->getMessage());
        }
    }


    public function destroy($id)
    {
        try {
            $salida = $this->salidaRepo->findById($id);

            if (!$salida) {
                return ApiResponseClass::sendResponse(false, null, Constants::SALIDA_NOT_FOUND, 404);
            }

            $lote = $this->loteRepo->find($salida->lote_id);

            $this->loteRepo->increaseStock($lote, $salida->cantidad);

            $deleted = $this->salidaRepo->delete($id);

            if (!$deleted) {
                return ApiResponseClass::sendResponse(false, null, Constants::SALIDA_DELETED_ERROR, 500);
            }

            return ApiResponseClass::sendResponse(true, null, Constants::SALIDA_DELETED);
        } catch (\Throwable $e) {
            return ApiResponseClass::throw($e->getMessage());
        }
    }
}
