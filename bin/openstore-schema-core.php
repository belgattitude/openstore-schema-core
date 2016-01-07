<?php

// Bootstrap
try {
    // Step 1: init autoloader
    
    $autoloadFiles = array(__DIR__ . '/../vendor/autoload.php',
                           __DIR__ . '/../../../autoload.php');
    
    $found = false;
    foreach ($autoloadFiles as $autoloadFile) {
        if (file_exists($autoloadFile)) {
            $found = true;
            require_once $autoloadFile;
            break;
        }
    }    
    if (!$found) {
        throw new \Exception('Cannot find composer vendor autoload, run composer update');
    }

    // Step 2 : init configuration

    $directories = array(getcwd(), getcwd() . DIRECTORY_SEPARATOR . 'config');

    $configFound = false;
    $configFile = null;
    foreach ($directories as $directory) {
        $configFile = $directory . DIRECTORY_SEPARATOR . 'openstore-schema-core.config.php';
        if (file_exists($configFile)) {
            $configFound = true;
            break;
        }
    }    
    
    if (!$found) {
        throw new \Exception("Cannot find configuration file '$configFile'");
    }
    $config = include $configFile;
    if (!$config) {
        throw new \Exception("Cannot parse or empty configuration file '$configFile'");
    }
} catch (\Exception $e) {
    echo $e->getMessage() . "\n";
    exit(1);
}

$setup = new OpenstoreSchema\Core\Tools\Setup($config['database'], $config['paths'], $config['namespace']);
$setup->setEnvironment($config['env']);
$setup->setProxyPath($config['proxy_path']);

$em = $setup->getEntityManager();

$cli = new Symfony\Component\Console\Application('openstore-schema-core console', '1.0.0');
$cli->setCatchExceptions(true);
// commands
$cli->addCommands(array(
    // DBAL Commands
    // 
    //new Doctrine\DBAL\Tools\Console\Command\RunSqlCommand(),
    //new Doctrine\DBAL\Tools\Console\Command\ImportCommand(),

    // ORM Commands
    new Doctrine\ORM\Tools\Console\Command\ClearCache\MetadataCommand(),
    new Doctrine\ORM\Tools\Console\Command\ClearCache\ResultCommand(),
    new Doctrine\ORM\Tools\Console\Command\ClearCache\QueryCommand(),
    new Doctrine\ORM\Tools\Console\Command\SchemaTool\CreateCommand(),
    new Doctrine\ORM\Tools\Console\Command\SchemaTool\UpdateCommand(),
    new Doctrine\ORM\Tools\Console\Command\SchemaTool\DropCommand(),
    //new Doctrine\ORM\Tools\Console\Command\EnsureProductionSettingsCommand(),
    //new Doctrine\ORM\Tools\Console\Command\ConvertDoctrine1SchemaCommand(),
    new Doctrine\ORM\Tools\Console\Command\GenerateRepositoriesCommand(),
    new Doctrine\ORM\Tools\Console\Command\GenerateEntitiesCommand(),
    new Doctrine\ORM\Tools\Console\Command\GenerateProxiesCommand(),
    //new Doctrine\ORM\Tools\Console\Command\ConvertMappingCommand(),
    new Doctrine\ORM\Tools\Console\Command\RunDqlCommand(),
    new Doctrine\ORM\Tools\Console\Command\ValidateSchemaCommand(),
    new Doctrine\ORM\Tools\Console\Command\InfoCommand(),
    
    new OpenstoreSchema\Core\Tools\Console\Command\Schema\CreateCommand(),
    new OpenstoreSchema\Core\Tools\Console\Command\Schema\RecreateExtraCommand(),
    new OpenstoreSchema\Core\Tools\Console\Command\Schema\UpdateCommand(),
    new OpenstoreSchema\Core\Tools\Console\Command\Schema\DropCommand()
));



// helpers
$helpers = array(
    'db' => new Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper($em->getConnection()),
    'em' => new Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper($em),
    'question' => new Symfony\Component\Console\Helper\QuestionHelper(),
);
foreach ($helpers as $name => $helper) {
    $cli->getHelperSet()->set($helper, $name);
}

$cli->run();
//return $cli;

