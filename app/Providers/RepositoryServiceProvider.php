<?php

namespace App\Providers;

use App\Interfaces\AuthRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Repository\AuthRepository;
use App\Repository\UserRepository;
use Illuminate\Support\ServiceProvider;

use App\Interfaces\LoteRepositoryInterface;
use App\Repository\LoteRepository;

class RepositoryServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->app->bind(AuthRepositoryInterface::class, AuthRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(LoteRepositoryInterface::class, LoteRepository::class);
    }
}
