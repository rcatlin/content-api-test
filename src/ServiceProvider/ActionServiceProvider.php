<?php

namespace RCatlin\ContentApi\ServiceProvider;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\UnitOfWork;
use League\Container\ServiceProvider\AbstractServiceProvider;
use RCatlin\ContentApi\Action;
use RCatlin\ContentApi\EntityHydrator;
use RCatlin\ContentApi\EntityTransformer;

class ActionServiceProvider extends AbstractServiceProvider
{
    protected $provides = [
        Action\EntityCreateAction::class,
        Action\PingAction::class,
    ];

    public function register()
    {
        $this->container->share(Action\EntityCreateAction::class, function () {
            $entityHydrator = $this->container->get(EntityHydrator::class);
            $entityManager = $this->container->get(EntityManager::class);
            $entityTransformer = $this->container->get(EntityTransformer::class);

            return new Action\EntityCreateAction($entityHydrator, $entityManager, $entityTransformer);
        });

        $this->container->share(Action\PingAction::class, function () {
            return new Action\PingAction();
        });
    }
}
