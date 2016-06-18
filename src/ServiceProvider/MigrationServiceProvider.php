<?php

namespace RCatlin\ContentApi\ServiceProvider;

use Doctrine\DBAL\Migrations\Configuration\Configuration;
use Doctrine\ORM\EntityManager;
use League\Container\ServiceProvider\AbstractServiceProvider;

class MigrationServiceProvider extends AbstractServiceProvider
{
    protected $provides = [
        Configuration::class,
    ];

    public function register()
    {
        $this->container->share(Configuration::class, function () {
            /** @var EntityManager $entityManager */
            $entityManager = $this->container->get(EntityManager::class);

            $configuration = new Configuration($entityManager->getConnection());

            $configuration->setName('RCatlin Content API Migrations');
            $configuration->setMigrationsNamespace('RCatlin\ContentApi\DBAL\Migration');
            $configuration->setMigrationsDirectory(__DIR__ . '/../DBAL/Migration');
            $configuration->setMigrationsTableName('rcatlin_content_api_migration_versions');
            $configuration->registerMigrationsFromDirectory(__DIR__ . '/../DBAL/Migration');

            return $configuration;
        });
    }
}
