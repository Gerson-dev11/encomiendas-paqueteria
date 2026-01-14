<?php

<<<<<<< HEAD
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
=======
use App\Domain\Exceptions\Interfaces\ApiExceptionInterface;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
>>>>>>> 6d71e0d (Cosas Realizadas: 1. Migrations y Seeders Configuradas establecidas y testeadas 2. Declaraciones de las reglas del negocios ENTITY 3. Desarrollo de los Modelos)

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
<<<<<<< HEAD
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
=======
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Illuminate\Foundation\Configuration\Middleware $middleware) {
        // Definimos los middlewares globales del proyecto (los de tu Kernel personalizado)
$middleware->use([
    \Illuminate\Http\Middleware\HandleCors::class,
    \App\Infrastructure\Http\Middleware\PreventRequestsDuringMaintenance::class,
    \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
    \App\Infrastructure\Http\Middleware\TrimStrings::class,
    \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
]);


    })

    // Aqui manejamos las exceptiones globales, para que se puedan capturar y manejar de manera global
    // Cuando una exception implemente la interface ApiExceptionInterface esta se va a ejecutar
    // y va a retornar un json con el codigo de error y el mensaje para poder manejarlo en el frontend
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (\Throwable $exception, $request) {
            if ($exception instanceof \App\Domain\Exceptions\Interfaces\ApiExceptionInterface) {
                // Para enviar solo metadata segura al frontend
                return response()->json([
                    'error_code' => $exception->getErrorCode(),
                    'message' => $exception->getMessage(),
                    'metadata' => method_exists($exception, 'getSafeMetadata')
                        ? $exception->getSafeMetadata()
                        : $exception->getMetadata(),
                    'severity' => $exception->getSeverity(),
                ], $exception->getHttpCode());
            }

            return null; // sigue con el flujo normal de Laravel
        });

        // 🔹 Manejo global para consola
        $exceptions->report(function (\Throwable $exception) {
            if ($exception instanceof \App\Domain\Exceptions\Interfaces\ApiExceptionInterface) {
                $output = new \Symfony\Component\Console\Output\ConsoleOutput;
                $output->writeln("<error>[{$exception->getErrorCode()}]</error> {$exception->getMessage()}");
                $output->writeln("<comment>Severity:</comment> {$exception->getSeverity()}");
                $output->writeln('<info>Metadata:</info> '.json_encode($exception->getMetadata()));

                return false; // evita que Laravel imprima el stack trace
            }

            return null;
        });
>>>>>>> 6d71e0d (Cosas Realizadas: 1. Migrations y Seeders Configuradas establecidas y testeadas 2. Declaraciones de las reglas del negocios ENTITY 3. Desarrollo de los Modelos)
    })->create();
