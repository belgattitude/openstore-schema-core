<?php
use Doctrine\ORM\Tools\Console\ConsoleRunner;

// replace with file to your own project bootstrap
try {
    // Step 1: init autoloader

    $autoloadFiles = [__DIR__ . '/../vendor/autoload.php',
        __DIR__ . '/../../../autoload.php'];

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

    $currentWorkingDirectory = getcwd();
    $directories = [
        $currentWorkingDirectory,
        $currentWorkingDirectory . DIRECTORY_SEPARATOR . 'config',
        dirname(__DIR__) . DIRECTORY_SEPARATOR . 'config'
    ];

    $configFound = false;
    $configFile = null;

    foreach ($directories as $directory) {
        $configFile = $directory . DIRECTORY_SEPARATOR . 'openstore-schema-core.config.php';
        if (file_exists($configFile)) {
            $configFound = true;
            break;
        }
    }

    if (!$configFound) {
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

$entityManager = $setup->getEntityManager();


return ConsoleRunner::createHelperSet($entityManager);
