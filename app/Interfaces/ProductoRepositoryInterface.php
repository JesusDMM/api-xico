<?php

namespace App\Interfaces;

interface ProductoRepositoryInterface
{
    public function getIdAndNombre();

    public function getIdNombrePresentacionCategoria();

    public function getByCategoria($categoria);

    public function getCategoriasUnicas();
}
