<?php

namespace App\Providers;

use App\Domain\Interfaces\UsersRepositoryInterfaceDomain; 
use App\Domain\Repositories\ClientesRepositoryDomain;
use App\Domain\Repositories\ViajeRepositoryDomain;
use App\Infrastructure\Repositories\ViajeRepository;
use App\Domain\Repositories\EmployeesRepositoryDomain;
use App\Domain\Repositories\ReportesRepositoryDomain;
use App\Infrastructure\Repositories\ReportesRepository;
use App\Domain\Repositories\PaquetesRepositoryDomain;
use App\Domain\Repositories\VehiclesRepositoryDomain;
use App\Infrastructure\Repositories\VehicleRepository;
use App\Domain\UseCases\Auth\LoginUserUseCase;
use App\Domain\UseCases\Auth\LogoutUserUseCase; 
use App\Infrastructure\Interfaces\UsersRepository;
use App\Infrastructure\Repositories\ClientesRepository;
use App\Infrastructure\Repositories\EmployeesRepositorie;
use App\Infrastructure\Repositories\PaquetesRepository;
use App\Domain\Repositories\RutasRepositoryDomain;
use App\Infrastructure\Repositories\RutasRepository;
use App\Domain\UseCases\Rutas\CreateRutaUseCase;
use App\Domain\UseCases\Rutas\GetRutaUseCase;
use App\Domain\UseCases\Rutas\UpdateRutaUseCase;
use App\Domain\UseCases\Rutas\DeleteRutaUseCase;
use App\Domain\UseCases\Rutas\ListRutasUseCase;
use App\Domain\UseCases\Reportes\GenerarReporteGananciasUseCase;
use App\Domain\UseCases\Reportes\GenerarReporteVentasUseCase;
use App\Domain\UseCases\Reportes\GenerarReportePaquetesUseCase;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        // ✅ SOLO usar UsersRepositoryInterfaceDomain (la que existe)
        $this->app->bind(UsersRepositoryInterfaceDomain::class, UsersRepository::class);

        // ✅ Repositorio de empleados
        $this->app->bind(EmployeesRepositoryDomain::class, EmployeesRepositorie::class);

        // ✅ Repositorio de clientes
        $this->app->bind(ClientesRepositoryDomain::class, ClientesRepository::class);

        // ✅ Repositorio de paquetes
        $this->app->bind(PaquetesRepositoryDomain::class, PaquetesRepository::class);

        $this->app->bind(ViajeRepositoryDomain::class, ViajeRepository::class);

        $this->app->bind(VehiclesRepositoryDomain::class, VehicleRepository::class);

        // ✅ Use case de login - CORREGIR para usar UsersRepositoryInterfaceDomain
        $this->app->bind(LoginUserUseCase::class, function ($app) {
            return new LoginUserUseCase($app->make(UsersRepositoryInterfaceDomain::class));
        });

        // ✅ Use case de logout
        $this->app->bind(LogoutUserUseCase::class, function ($app) {
            return new LogoutUserUseCase($app->make(UsersRepositoryInterfaceDomain::class));
        });

        // EL de RUTAS
        // Repositories
        $this->app->bind(RutasRepositoryDomain::class, RutasRepository::class);

        // Use Cases
        $this->app->bind(CreateRutaUseCase::class, function ($app) {
            return new CreateRutaUseCase($app->make(RutasRepositoryDomain::class));
        });

        $this->app->bind(GetRutaUseCase::class, function ($app) {
            return new GetRutaUseCase($app->make(RutasRepositoryDomain::class));
        });

        $this->app->bind(UpdateRutaUseCase::class, function ($app) {
            return new UpdateRutaUseCase($app->make(RutasRepositoryDomain::class));
        });

        $this->app->bind(DeleteRutaUseCase::class, function ($app) {
            return new DeleteRutaUseCase($app->make(RutasRepositoryDomain::class));
        });

        $this->app->bind(ListRutasUseCase::class, function ($app) {
            return new ListRutasUseCase($app->make(RutasRepositoryDomain::class));
        });

        // Reportes
        $this->app->bind(ReportesRepositoryDomain::class, ReportesRepository::class);

        $this->app->bind(GenerarReporteGananciasUseCase::class, function ($app) {
            return new GenerarReporteGananciasUseCase($app->make(ReportesRepositoryDomain::class));
        });

        $this->app->bind(GenerarReporteVentasUseCase::class, function ($app) {
            return new GenerarReporteVentasUseCase($app->make(ReportesRepositoryDomain::class));
        });

        $this->app->bind(GenerarReportePaquetesUseCase::class, function ($app) {
            return new GenerarReportePaquetesUseCase($app->make(ReportesRepositoryDomain::class));
        });
    }

    public function boot()
    {
        //
    }
}