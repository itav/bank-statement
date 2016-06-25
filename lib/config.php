<?php


$app['view_dirs'] = [
    __DIR__ . '/../src/views/%name%',
    __DIR__ . '/../vendor/itav/form/src/views/php/%name%',
    __DIR__ . '/../vendor/itav/table/src/views/php/%name%',
];

$app['twig_dirs'] = [
    __DIR__ . '/../src/views',
    __DIR__ . '/../vendor/itav/form/src/views/twig',
    __DIR__ . '/../vendor/itav/table/src/views/twig',
];

$app['redis_host'] = 'localhost';
$app['redis_port'] = '6379';

$app['mongo_host'] = 'localhost';
$app['mongo_port'] = '27017';