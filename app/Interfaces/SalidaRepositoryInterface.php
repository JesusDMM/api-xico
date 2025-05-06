<?php

namespace App\Interfaces;

interface SalidaRepositoryInterface
{
    public function all();
    public function find($id);
    public function ExistsById($id);
    public function findById($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function findByLoteId($loteId);
    public function bulkDelete($salidaId);
}
