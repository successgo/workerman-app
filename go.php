<?php

use Workerman\Connection\TcpConnection;
use Workerman\Protocols\Http\Request;
use Workerman\Worker;

require __DIR__ . '/vendor/autoload.php';

$http_worker = new Worker('http://127.0.0.1:8800');

$http_worker->count = 2;

$http_worker->onMessage = function (TcpConnection $conn, Request $req) {
    $conn->send('hello world');
};


Worker::runAll();
