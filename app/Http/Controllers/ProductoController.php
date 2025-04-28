<?php

namespace App\Http\Controllers;

use App\Interfaces\ProductoRepositoryInterface;
use Illuminate\Http\Request;
use App\Classes\ApiResponseClass;
use App\Constants\Constants;

class ProductoController extends Controller
{
    protected $productoRepo;

    public function __construct(ProductoRepositoryInterface $productoRepo)
    {
        $this->productoRepo = $productoRepo;
    }

    public function getIdAndNombre()
    {
        try {
            $productos = $this->productoRepo->getIdAndNombre();
            return ApiResponseClass::sendResponse(true, $productos->toArray(), Constants::SUCCESS);
        } catch (\Throwable $e) {
            return ApiResponseClass::throw($e->getMessage());
        }
    }

    public function getIdNombrePresentacionCategoria()
    {
        try {
            $productos = $this->productoRepo->getIdNombrePresentacionCategoria();
            return ApiResponseClass::sendResponse(true, $productos->toArray(), Constants::SUCCESS);
        } catch (\Throwable $e) {
            return ApiResponseClass::throw($e->getMessage());
        }
    }

    public function getByCategoria($categoria)
    {
        try {
            $productos = $this->productoRepo->getByCategoria($categoria);
            return ApiResponseClass::sendResponse(true, $productos->toArray(), Constants::SUCCESS);
        } catch (\Throwable $e) {
            return ApiResponseClass::throw($e->getMessage());
        }
    }

    public function getCategoriasUnicas()
    {
        try {
            $categorias = $this->productoRepo->getCategoriasUnicas();
            return ApiResponseClass::sendResponse(true, $categorias->toArray(), Constants::SUCCESS);
        } catch (\Throwable $e) {
            return ApiResponseClass::throw($e->getMessage());
        }
    }
}
