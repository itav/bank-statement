<?php

//$app = new Silex\Application();

$app->match('/import', 'App\\Finance\\Bank\\Controller::importAction')->method('GET|POST');
$app->match('/list', 'App\\Finance\\Bank\\Controller::listReportAction')->method('GET|POST');
$app->match('/list/record/{id}', 'App\\Finance\\Bank\\Controller::listRecordAction')->method('GET|POST')->assert('id', '\w+');
$app->get('/del/{id}', 'App\\Finance\\Bank\\Controller::deleteReportAction')->assert('id', '\w+');
$app->get('/clone/{id}', 'App\\Finance\\Bank\\Controller::cloneReportAction')->assert('id', '\w+');
$app->get('/del/record/{id}/{idr}', 'App\\Finance\\Bank\\Controller::deleteRecordAction')->assert('id', '\w+', 'idr', '\w+');
$app->get('/print/{id}', 'App\\Finance\\Bank\\Controller::printReportAction')->assert('id', '\w+');