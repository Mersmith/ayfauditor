<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        then: function () {
            Route::prefix('erp')
                ->name('erp.')
                ->group(function () {
                    foreach (glob(base_path('routes/erp/*.php')) as $file) {
                        require $file;
                    }
                });
        },
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->redirectUsersTo('/erp/cliente');
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
