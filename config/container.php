<?php

use League\Container\Container;
use RCatlin\ContentApi\ServiceProvider;

require_once __DIR__ . '/../vendor/autoload.php';

$container = new Container();

$container->addServiceProvider(ServiceProvider\ActionServiceProvider::class);
$container->addServiceProvider(ServiceProvider\ApplicationServiceProvider::class);
$container->addServiceProvider(ServiceProvider\MiddlewareServiceProvider::class);

return $container;