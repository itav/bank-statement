<?php

use Itav\Component\Serializer\Serializer;
use Symfony\Component\Templating\PhpEngine;
use Symfony\Component\Templating\TemplateNameParser;
use Symfony\Component\Templating\Loader\FilesystemLoader;
use Symfony\Component\Templating\Helper\SlotsHelper;

//$app = new Silex\Application();
require_once 'config.php';

$app['serializer'] = function() {
    return new Serializer();
};

$app['templating'] = function($app) {
    $loader = new FilesystemLoader($app['view_dirs']);
    $templating = new PhpEngine(new TemplateNameParser(), $loader);
    $templating->set(new SlotsHelper());
    return $templating;
};

$app['twig'] = function($app) {
    $loader = new Twig_Loader_Filesystem($app['twig_dirs']);
    $twig = new Twig_Environment($loader, [
        'cache' => __DIR__ . '/../app/cache/twig',
        'debug' => true,
    ]);
    return $twig;
};

$app['redis'] = function($app){
    $redis = new Redis();
    $redis->connect($app['redis_host'], $app['redis_port']);
    return $redis;
};

$app['mongo'] = function($app){
    $host = $app['mongo_host'];
    $port = $app['mongo_port'];
    $str = "mongodb://$host:$port";
    $mongo = new \MongoDB\Driver\Manager($str);
    return $mongo;
};

$app['statement_repo'] = function($app){
    $repo = new \App\Finance\Bank\StatementRepo($app);
    return $repo;
};