<?php
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;


//development!!
ini_set('display_errors', 1);
error_reporting(E_ALL);

require(__DIR__ . '/../vendor/autoload.php');

$conf = include_once(__DIR__ .'/../conf/config.php');

$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new \Aac\Sockets($conf)
        )
    ),

    9000
);

$server->run();