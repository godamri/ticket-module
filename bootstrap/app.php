<?php

use App\Exceptions\GlobalException;
use App\Http\Middleware\AcceptJson;
use App\Http\Middleware\OverrideDefaultToApiRequest;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        api: __DIR__.'/../routes/api.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->append(OverrideDefaultToApiRequest::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->report(function(GlobalException $e) {});
    })->create();
