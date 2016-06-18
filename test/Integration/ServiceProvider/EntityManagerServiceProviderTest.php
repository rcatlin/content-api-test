<?php

namespace RCatlin\ContentApi\Test\Integration\ServiceProvider;

use Doctrine\ORM\EntityManager;
use RCatlin\ContentApi\Test\ContainerAware;

class EntityManagerServiceProviderTest extends \PHPUnit_Framework_TestCase
{
    use ContainerAware;

    public function testProvidesEntityManager()
    {
        $container = $this->getContainer();

        $entityManager = $container->get(EntityManager::class);

        $this->assertInstanceOf(EntityManager::class, $entityManager);
        $this->assertSame($entityManager, $container->get(EntityManager::class));
    }
}
