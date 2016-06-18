<?php

namespace RCatlin\ContentApi\ServiceProvider;

use League\Container\ServiceProvider\AbstractServiceProvider;
use RCatlin\ContentApi\Middleware;
use Refinery29\Piston\Piston;

class ApplicationServiceProvider extends AbstractServiceProvider
{
    protected $provides = [
        Piston::class,
    ];

    public function register()
    {
        $this->container->share(Piston::class, function () {
            $piston = new Piston($this->container);

            $piston->addMiddleware($this->container->get(Middleware\Route::class));

            return $piston;
        });
    }
}
