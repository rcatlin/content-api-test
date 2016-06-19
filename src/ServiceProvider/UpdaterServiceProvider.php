<?php

namespace RCatlin\ContentApi\ServiceProvider;

use Doctrine\ORM\EntityManager;
use League\Container\ServiceProvider\AbstractServiceProvider;
use RCatlin\ContentApi\EntityUpdater;

class UpdaterServiceProvider extends AbstractServiceProvider
{
    protected $provides = [
        EntityUpdater::class,
    ];

    public function register()
    {
        $this->container->share(EntityUpdater::class, function () {
            $entityManager = $this->container->get(EntityManager::class);

            return new EntityUpdater($entityManager);
        });
    }
}
