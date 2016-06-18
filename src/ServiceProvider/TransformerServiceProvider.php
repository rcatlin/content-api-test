<?php

namespace RCatlin\ContentApi\ServiceProvider;

use Doctrine\ORM\EntityManager;
use League\Container\ServiceProvider\AbstractServiceProvider;
use RCatlin\ContentApi\EntityTransformer;

class TransformerServiceProvider extends AbstractServiceProvider
{
    protected $provides = [
        EntityTransformer::class,
    ];

    public function register()
    {
        $this->container->share(EntityTransformer::class, function () {
            $entityManager = $this->container->get(EntityManager::class);

            return new EntityTransformer($entityManager);
        });
    }
}
