<?php

defined('APP_PATH') || define('APP_PATH', realpath('.'));

$config = array(
    'ovodatabase' => array(
        'adapter'     => 'Mysql',
        'charset'     => 'utf8',

        'host'        => '[your_host]',
        'username'    => '[username]',
        'password'    => '[password]',
        'dbname'      => '[dbname]',
    ),
    'application' => array(
        'controllersDir' => APP_PATH . '/app/controllers/',
        'modelsDir'      => APP_PATH . '/app/models/',
        'migrationsDir'  => APP_PATH . '/app/migrations/',
        'viewsDir'       => APP_PATH . '/app/views/',
        'pluginsDir'     => APP_PATH . '/app/plugins/',
        'libraryDir'     => APP_PATH . '/app/library/',
        'cacheDir'       => APP_PATH . '/var/cache/'
    )
);

return new \Phalcon\Config($config);
