<?php

namespace RCatlin\ContentApi\ServiceProvider;

use Doctrine\ORM\EntityManager;
use League\Container\ServiceProvider\AbstractServiceProvider;
use RCatlin\ContentApi\Action;
use RCatlin\ContentApi\EntityHydrator;
use RCatlin\ContentApi\EntityTransformer;
use RCatlin\ContentApi\EntityUpdater;

class ActionServiceProvider extends AbstractServiceProvider
{
    protected $provides = [
        Action\EntityCreateAction::class,
        Action\EntityDeleteAction::class,
        Action\EntityPartialUpdateAction::class,
        Action\EntityRetrieveAction::class,
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

        $this->container->share(Action\EntityDeleteAction::class, function () {
            $entityManager = $this->container->get(EntityManager::class);

            return new Action\EntityDeleteAction($entityManager);
        });

        $this->container->share(Action\EntityRetrieveAction::class, function () {
            $entityManager = $this->container->get(EntityManager::class);
            $entityTransformer = $this->container->get(EntityTransformer::class);

            return new Action\EntityRetrieveAction($entityManager, $entityTransformer);
        });

        $this->container->share(Action\EntityPartialUpdateAction::class, function () {
            $entityUpdater = $this->container->get(EntityUpdater::class);
            $entityManager = $this->container->get(EntityManager::class);
            $entityTransformer = $this->container->get(EntityTransformer::class);

            return new Action\EntityPartialUpdateAction($entityUpdater, $entityManager, $entityTransformer);
        });

        $this->container->share(Action\PingAction::class, function () {
            return new Action\PingAction();
        });
    }
}
