<?php

namespace App\Providers;

use App\Interfaces\AuthRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Repository\AuthRepository;
use App\Repository\UserRepository;
use Illuminate\Support\ServiceProvider;

use App\Interfaces\LoteRepositoryInterface;
use App\Repository\LoteRepository;

use App\Interfaces\SalidaRepositoryInterface;
use App\Repository\SalidaRepository;

use App\Interfaces\EspecificacionIncidenciaRepositoryInterface;
use App\Repository\EspecificacionIncidenciaRepository;

use App\Interfaces\ProductoRepositoryInterface;
use App\Repository\ProductoRepository;

class RepositoryServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->bind(AuthRepositoryInterface::class, AuthRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(LoteRepositoryInterface::class, LoteRepository::class);
        $this->app->bind(SalidaRepositoryInterface::class, SalidaRepository::class);
        $this->app->bind(EspecificacionIncidenciaRepositoryInterface::class, EspecificacionIncidenciaRepository::class);
        $this->app->bind(ProductoRepositoryInterface::class, ProductoRepository::class);
    }
}
