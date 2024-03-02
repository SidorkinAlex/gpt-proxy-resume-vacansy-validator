#!/usr/bin/env php
<?php

declare(strict_types=1);

use Swoole\Http\Request;
use Swoole\Http\Response;
use Swoole\Http\Server;
use Swoole\Coroutine;


require_once "./vendor/autoload.php";
function isValidJSON($string) {
    json_decode($string);
    return (json_last_error() == JSON_ERROR_NONE);
}

$http = new Server("0.0.0.0", 9501);
$app = new \Sidalex\CandidateVacancyEstimationGpt\Application();
$http->on(
    "start",
    function (Server $http) use ($app) {
        echo "Swoole HTTP server is started.\n";
    }
);
$http->on(
    "request",
    function (Request $request, Response $response) use ($app) {
        $app->execute($request,$response);
    }
);
$http->start();
