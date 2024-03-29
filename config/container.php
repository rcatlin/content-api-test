<?php

use League\Container\Container;
use RCatlin\ContentApi\ServiceProvider;

require_once __DIR__ . '/../vendor/autoload.php';

$container = new Container();

$container->addServiceProvider(ServiceProvider\ActionServiceProvider::class);
$container->addServiceProvider(ServiceProvider\ApplicationServiceProvider::class);
$container->addServiceProvider(ServiceProvider\HydratorServiceProvider::class);
$container->addServiceProvider(ServiceProvider\EntityManagerServiceProvider::class);
$container->addServiceProvider(ServiceProvider\MiddlewareServiceProvider::class);
$container->addServiceProvider(ServiceProvider\MigrationServiceProvider::class);
$container->addServiceProvider(ServiceProvider\TransformerServiceProvider::class);
$container->addServiceProvider(ServiceProvider\UpdaterServiceProvider::class);

return $container;
