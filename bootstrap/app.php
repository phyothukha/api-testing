<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\ControlProduct;
use App\Http\Middleware\ResponseToJson;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
//        $middleware->append(ControlProduct::class);
//        $middleware->appendToGroup('productControl',[
//            ControlProduct::class
//        ]);

        $middleware->append(\Illuminate\Http\Middleware\HandleCors::class);
        $middleware->use(
            [ResponseToJson::class]
        );


        $middleware->alias([
            'subscribed' => ControlProduct::class
        ]);
    })

    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
