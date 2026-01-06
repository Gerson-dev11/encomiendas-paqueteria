<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domain\Repositories\EmployeesRepositoryDomain;
use App\Infrastructure\Repositories\EmployeesRepositorie;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            EmployeesRepositoryDomain::class,
            EmployeesRepositorie::class
        );
    }
}
