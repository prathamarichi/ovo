<?php

$loader = new \Phalcon\Loader();

$namespaces = array(
    'Phalcon\Libraries' => __DIR__ . '/../system/libraries/Phalcon',
    'System\Models' => __DIR__ . '/../system/models/',
    'System\Libraries' => __DIR__ . '/../system/libraries',
);

$loader->registerNamespaces($namespaces)->register();