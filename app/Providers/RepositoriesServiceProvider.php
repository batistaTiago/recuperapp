<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Domain\Repositories\UserRepositoryInterface;
use App\Repositories\MysqlUserRepository;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class RepositoriesServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->app->bind(UserRepositoryInterface::class, MysqlUserRepository::class);
    }
}
