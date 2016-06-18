<?php

use Refinery29\Piston\Piston;

require_once __DIR__ . '/../vendor/autoload.php';

/** @var \League\Container\Container $container */
$container = require __DIR__ . '/../config/container.php';

/** @var Piston $piston */
$piston = $container->get(Piston::class);

$piston->launch();
