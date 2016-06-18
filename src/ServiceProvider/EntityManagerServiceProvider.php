<?php

namespace RCatlin\ContentApi\ServiceProvider;

use Doctrine\Common\Cache\ArrayCache;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManager;
use League\Container\ServiceProvider\AbstractServiceProvider;

class EntityManagerServiceProvider extends AbstractServiceProvider
{
    protected $provides = [
        EntityManager::class,
    ];

    public function register()
    {
        $this->container->share(EntityManager::class, function () {
            $params = [
                'driver' => 'pdo_sqlite',
                'user' => 'root',
                'password' => '',
                'path' => __DIR__ . '/../../data',
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
    }
}
