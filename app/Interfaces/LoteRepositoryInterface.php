<?php

namespace App\Interfaces;

interface LoteRepositoryInterface
{
    public function all();
    public function find($id);
    public function ExistsById($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
}
