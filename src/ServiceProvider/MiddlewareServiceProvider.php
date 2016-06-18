<?php

namespace RCatlin\ContentApi\ServiceProvider;

use League\Container\ServiceProvider\AbstractServiceProvider;
use RCatlin\ContentApi\Middleware;

class MiddlewareServiceProvider extends AbstractServiceProvider
{
    protected $provides = [
        Middleware\Route::class,
    ];

    public function register()
    {
        $this->container->share(Middleware\Route::class, function () {
            return new Middleware\Route();
        });
    }
}
