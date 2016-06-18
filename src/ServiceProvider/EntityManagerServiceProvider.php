<?php

namespace RCatlin\ContentApi\ServiceProvider;

use Doctrine\Common\Cache\ArrayCache;
use Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper;
use Doctrine\ORM\UnitOfWork;
use League\Container\ServiceProvider\AbstractServiceProvider;
use Symfony\Component\Console\Helper\HelperSet;

class EntityManagerServiceProvider extends AbstractServiceProvider
{
    protected $provides = [
        EntityManager::class,
        HelperSet::class,
        UnitOfWork::class,
    ];

    public function register()
    {
        $this->container->share(EntityManager::class, function () {
            $params = [
                'driver' => 'pdo_sqlite',
                'user' => 'root',
                'password' => '',
                'path' => __DIR__ . '/../../data/db.sqlite',
                'memory' => false,
            ];

            $config = new Configuration();

            $annotationDriver = $config->newDefaultAnnotationDriver(
                [
                    __DIR__ . '/../Entity',
                ],
                false
            );

            $cache = new ArrayCache();

            $config->setMetadataCacheImpl($cache);
            $config->setMetadataDriverImpl($annotationDriver);
            $config->setProxyDir(__DIR__ . '/../../proxies');
            $config->setProxyNamespace('RCatlin\ContentApi\Proxy');
            $config->setAutoGenerateProxyClasses(true);

            return EntityManager::create($params, $config);
        });

        $this->container->share(HelperSet::class, function () {
            /** @var EntityManager $entityManager */
            $entityManager = $this->container->get(EntityManager::class);

            return new HelperSet([
                'db' => new ConnectionHelper($entityManager->getConnection()),
                'em' => new EntityManagerHelper($entityManager),
            ]);
        });

        $this->container->share(UnitOfWork::class, function () {
            /** @var EntityManager $entityManager */
            $entityManager = $this->container->get(EntityManager::class);

            return $entityManager->getUnitOfWork();
        });
    }
}
