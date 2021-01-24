<?php

require __DIR__ . '/../../vendor/autoload.php';

$worker = new \Workerman\Worker('http://127.0.0.1:50080');

$worker->count = 1;
$worker->name = 'cookie';

$worker->onMessage = function (\Workerman\Connection\TcpConnection $connection, \Workerman\Protocols\Http\Request $request) {
    $page = $request->cookie('last-visit-page', 'none');

    $response = new \Workerman\Protocols\Http\Response();
    $response->cookie('last-visit-page', $request->path());
    $response->withBody('last visit page: ' . $page);

    $connection->send($response);
};

\Workerman\Worker::runAll();
