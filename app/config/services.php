<?php

/**
 * Services are globally registered in this file
 *
 * @var \Phalcon\Config $config
 */

use \Phalcon\Di\FactoryDefault;
use \Phalcon\Mvc\View;
use \Phalcon\Mvc\View\Engine\Volt as VoltEngine;
use \Phalcon\Session\Adapter\Files as SessionAdapter;
use \Phalcon\Http\Response\Cookies;
use \Phalcon\Flash\Session as Flash;
use \Phalcon\Mvc\Model\Manager as ModelManager;
use \Phalcon\Mvc\Dispatcher as Dispatcher;

/**
 * The FactoryDefault Dependency Injector automatically register the right services providing a full stack framework
 */
$di = new FactoryDefault();

/**
 * set config
 */
$di->setShared('config', function () use ($config) {
    return $config;
});

$di->set('modelsManager', function () {
    return new ModelManager();
});

$di->set('flash', function () {
    return new Flash();
});

/**
 * Start the session the first time some component request the session service
 */
$di->setShared('session', function () {
    $session = new SessionAdapter();
    $session->start();

    return $session;
});

/**
 * Setting up the view component
 */
$di->setShared('view', function () use ($config) {

    $view = new View();

    $view->disable();

    return $view;
});

$di->setShared('ovodatabase', function () use ($config) {
    $dbConfig = $config->ovodatabase->toArray();
    $adapter = $dbConfig['adapter'];
    unset($dbConfig['adapter']);

    $class = 'Phalcon\Db\Adapter\Pdo\\' . $adapter;

    return new $class($dbConfig);
});

/**
 * Registering a router
 */
$di['router'] = function () {
    return require __DIR__ . '/routes.php';
};

/**
 * setting dispatcher
 */
$di->set('dispatcher', function () use ($di) {
    $evManager = $di->getShared('eventsManager');
    $evManager->attach('dispatch:beforeException', function ($event, \Phalcon\Mvc\Dispatcher $dispatcher, \Exception $exception) {
        switch ($exception->getCode()) {
            case Dispatcher::EXCEPTION_HANDLER_NOT_FOUND:
            case Dispatcher::EXCEPTION_ACTION_NOT_FOUND:
                return false;
        }
    });

    $dispatcher = new Dispatcher();
    $dispatcher->setDefaultNamespace('Api\Controllers');
    $dispatcher->setEventsManager($evManager);

    return $dispatcher;
}, true);

/**
 * setting CURL
 */
$di->set('curl', function () {
    $curl = ClientRequest::getProvider();
    $curl->setConnectTimeout(5);
    $curl->setTimeout(6);
    return $curl;
});

$di->set('cookies', function () {
    $cookies = new Cookies();
    $cookies->useEncryption(false);
    return $cookies;
}, true);