<?php

require_once __DIR__ . '/../../vendor/autoload.php';

$worker = new \Workerman\Worker('http://127.0.0.1:8800');

$worker->count = 2;
$worker->onMessage = function (\Workerman\Connection\TcpConnection $connection, \Workerman\Protocols\Http\Request $request) {
    $path = $request->path();
    $method = $request->method();
    $data = ['name' => 'Success Go'];

    $response = new \Workerman\Protocols\Http\Response();
    $response->withHeader('Content-Type', 'application/json; charset=UTF-8');
    $response->withBody(json_encode(compact('path', 'method', 'data')));

    $connection->send($response);
};

\Workerman\Worker::runAll();
