<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Interfaces\LoteRepositoryInterface;
use App\Classes\ApiResponseClass;
use App\Constants\Constants;

class LoteController extends Controller
{
    protected $repo;

    public function __construct(LoteRepositoryInterface $repo)
    {
        $this->repo = $repo;
    }

    public function index()
    {
        $lotes = $this->repo->all();
        return ApiResponseClass::sendResponse(true, $lotes->toArray(), Constants::SUCCESS);
    }

    public function show($id)
    {
        $lote = $this->repo->find($id);

        if (!$lote) {
            return ApiResponseClass::sendResponse(false, null, Constants::LOTE_NOT_FOUND, 404);
        }

        return ApiResponseClass::sendResponse(true, $lote->toArray(), Constants::SUCCESS);
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|string|max:255',
                'producto_id' => 'required|int|min:1',
                'tamaño_lote' => 'required|integer',
                'caducidad' => 'required|date',
            ]);

            $request->merge([
                'stock' => $request->input('tamaño_lote')
            ]);

            $data = $request->all();

            $existsId = $this->repo->ExistsById($data['id']);

            if ($existsId) {
                return ApiResponseClass::sendResponse(false, null, Constants::LOTE_ID_DUPLICADO, 409);
            }

            $lote = $this->repo->create($data);

            if (!$lote) {
                return ApiResponseClass::sendResponse(false, null, Constants::LOTE_CREATE_ERROR, 500);
            }

            return ApiResponseClass::sendResponse(true, $lote->toArray(), Constants::LOTE_CREATED, 201);
        } catch (\Throwable $e) {
            return ApiResponseClass::throw($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'producto_id' => 'required|int|min:1',
                'tamaño_lote' => 'required|integer',
                'caducidad' => 'required|date',
            ]);

            if (!$this->repo->ExistsById($id)) {
                return ApiResponseClass::sendResponse(false, null, Constants::LOTE_NOT_FOUND, 409);
            }

            $data = $request->all();
            $lote = $this->repo->update($id, $data);

            if (!$lote) {
                return ApiResponseClass::sendResponse(false, null, Constants::LOTE_UPDATE_INVALID_STOCK, 404);
            }

            return ApiResponseClass::sendResponse(true, $lote->toArray(), Constants::LOTE_UPDATED);
        } catch (\Throwable $e) {
            return ApiResponseClass::throw($e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            if (!$this->repo->ExistsById($id)) {
                return ApiResponseClass::sendResponse(false, null, Constants::LOTE_NOT_FOUND, 409);
            }

            $this->repo->delete($id);

            return ApiResponseClass::sendResponse(true, null, Constants::LOTE_DELETED);
        } catch (\Throwable $e) {
            return ApiResponseClass::throw($e->getMessage());
        }
    }

    public function getLotesConSalidasYIncidencias()
    {
        try {
            $lotes = $this->repo->getAllLotesConSalidasYIncidencias();

            return ApiResponseClass::sendResponse(true, $lotes->toArray(), Constants::SUCCESS);
        } catch (\Throwable $e) {
            return ApiResponseClass::throw($e->getMessage());
        }
    }

    public function getLoteConSalidasYIncidencias($loteId)
    {
        try {
            $lote = $this->repo->getLoteConSalidasYIncidencias($loteId);
            return ApiResponseClass::sendResponse(true, $lote->toArray(), Constants::SUCCESS);
        } catch (\Throwable $e) {
            return ApiResponseClass::throw($e->getMessage());
        }
    }
}
