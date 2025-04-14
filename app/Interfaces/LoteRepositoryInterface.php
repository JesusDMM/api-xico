<?php

namespace App\Interfaces;

use App\Models\Lote;

interface LoteRepositoryInterface
{
    public function all();
    public function find($id);
    public function ExistsById($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function decreaseStock(Lote $lote, $cantidad);
    public function increaseStock(Lote $lote, $cantidad);
    public function ajustarStockPorActualizacion(Lote $lote, int $cantidadAnterior, int $nuevaCantidad): bool;
}
