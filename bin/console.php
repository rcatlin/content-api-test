<?php

$container = require_once __DIR__ . '/../config/container.php';

$console = new Symfony\Component\Console\Application();

$helperSet = $container->get(\Symfony\Component\Console\Helper\HelperSet::class);
$helperSet->set(new \Symfony\Component\Console\Helper\QuestionHelper(), 'dialog');

$console->setHelperSet($helperSet);

$commands = [
    new Doctrine\DBAL\Tools\Console\Command\ImportCommand(),
    new Doctrine\DBAL\Tools\Console\Command\ReservedWordsCommand(),
    new Doctrine\DBAL\Tools\Console\Command\RunSqlCommand(),

    new Doctrine\ORM\Tools\Console\Command\ConvertDoctrine1SchemaCommand(),
    new Doctrine\ORM\Tools\Console\Command\ConvertDoctrine1SchemaCommand(),
    new Doctrine\ORM\Tools\Console\Command\EnsureProductionSettingsCommand(),
    new Doctrine\ORM\Tools\Console\Command\GenerateEntitiesCommand(),
    new Doctrine\ORM\Tools\Console\Command\GenerateProxiesCommand(),
    new Doctrine\ORM\Tools\Console\Command\GenerateRepositoriesCommand(),
    new Doctrine\ORM\Tools\Console\Command\InfoCommand(),
    new Doctrine\ORM\Tools\Console\Command\MappingDescribeCommand(),
    new Doctrine\ORM\Tools\Console\Command\RunDqlCommand(),
    new Doctrine\ORM\Tools\Console\Command\ValidateSchemaCommand(),

    new Doctrine\DBAL\Migrations\Tools\Console\Command\DiffCommand(),
    new Doctrine\DBAL\Migrations\Tools\Console\Command\ExecuteCommand(),
    new Doctrine\DBAL\Migrations\Tools\Console\Command\GenerateCommand(),
    new Doctrine\DBAL\Migrations\Tools\Console\Command\LatestCommand(),
    new Doctrine\DBAL\Migrations\Tools\Console\Command\MigrateCommand(),
    new Doctrine\DBAL\Migrations\Tools\Console\Command\StatusCommand(),
    new Doctrine\DBAL\Migrations\Tools\Console\Command\VersionCommand(),
];

$console->addCommands($commands);

$console->run();


