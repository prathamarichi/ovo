<?php

use Phalcon\DI\FactoryDefault\CLI as CliDI,
    Phalcon\CLI\Console as ConsoleApp;
use Phalcon\Mvc\Collection\Manager as CollectionManager;
use \Phalcon\Session\Adapter\Files as SessionAdapter;

define('VERSION', '1.0.0');

// Using the CLI factory default services container
$di = new CliDI();

// Define path to application directory
defined('APPLICATION_PATH')
|| define('APPLICATION_PATH', realpath(dirname(__FILE__)));

/**
 * Register the autoloader and tell it to register the tasks directory
 */
$loader = new \Phalcon\Loader();

$namespaces = array(
    'System\Models' => __DIR__ . '/../app/system/models/',
    // 'System\Language' => __DIR__ . '/../app/system/languages',
    'System\Libraries' => __DIR__ . '/../app/system/libraries',
    'Phalcon\Libraries' => __DIR__ . '/../app/system/libraries/Phalcon'
);

$loader->registerNamespaces($namespaces)->register();

$loader->registerDirs(
    array(
        APPLICATION_PATH . '/../app/system/tasks'
    )
)->register();

// Load the configuration file (if any)
$configFile = __DIR__ . "/../app/config/config.php";
if (is_readable($configFile)) {
    $config = include $configFile;
    $di->set("config", $config);
}

/**
 * Start the session the first time some component request the session service
 */
$di->setShared('session', function () {
    $session = new SessionAdapter();
    $session->start();

    return $session;
});

$di->set('collectionManager', function () {
    // Setting a default EventsManager
    $modelsManager = new CollectionManager();
    return $modelsManager;
}, true);

// Create a console application
$console = new ConsoleApp();
$console->setDI($di);

$di->setShared('ovodatabase', function () use ($config) {
    $dbConfig = $config->ovodatabase->toArray();
    $adapter = $dbConfig['adapter'];
    unset($dbConfig['adapter']);

    $class = 'Phalcon\Db\Adapter\Pdo\\' . $adapter;

    return new $class($dbConfig);
});

/**
 * Process the console arguments
 */
$arguments = array();
foreach ($argv as $k => $arg) {
    if ($k == 1) {
        $arguments['task'] = $arg;
    } elseif ($k == 2) {
        $arguments['action'] = $arg;
    } elseif ($k >= 3) {
        $arguments['params'][] = $arg;
    }
}

// Define global constants for the current task and action
define('CURRENT_TASK',   (isset($argv[1]) ? $argv[1] : null));
define('CURRENT_ACTION', (isset($argv[2]) ? $argv[2] : null));

try {
    // Handle incoming arguments
    $console->handle($arguments);
} catch (\Phalcon\Exception $e) {
    echo $e->getMessage();
    exit(255);
}
