<?php

namespace RCatlin\ContentApi\ServiceProvider;

use Doctrine\ORM\EntityManager;
use League\Container\ServiceProvider\AbstractServiceProvider;
use RCatlin\ContentApi\EntityHydrator;

class HydratorServiceProvider extends AbstractServiceProvider
{
    protected $provides = [
        EntityHydrator::class,
    ];

    public function register()
    {
        $this->container->share(EntityHydrator::class, function () {
            $entityManager = $this->container->get(EntityManager::class);

            return new EntityHydrator($entityManager);
        });
    }
}
