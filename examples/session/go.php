<?php

require __DIR__ . '/../../vendor/autoload.php';

$worker = new \Workerman\Worker('http://127.0.0.1:50080');

$worker->count = 2;

$worker->onMessage = function (\Workerman\Connection\TcpConnection $connection, \Workerman\Protocols\Http\Request $request) {
    $path = $request->path();

    switch ($path) {
        case '/session/set-session':
            $session = $request->session();

            $name = $request->get('name');

            if ($name) {
                $session->set('name', $name);
                $data = ['ok' => true];
            } else {
                $data = ['ok' => false];
            }

            $response = new \Workerman\Protocols\Http\Response();
            $response->withHeader('Content-Type', 'application/json');
            $response->withBody(json_encode(compact('data')));

            break;
        case '/session/get-session':
            $session = $request->session();
            $name = $session->get('name');

            $response = new \Workerman\Protocols\Http\Response();
            $response->withHeader('Content-Type', 'application/json');
            $response->withBody(json_encode(compact('name')));

            break;
        default:
            $response = new \Workerman\Protocols\Http\Response();
            $response->withStatus(404);
            $response->withHeader('Content-Type', 'application/json');
            $response->withBody(json_encode(['route' => 'not found']));
    }

    $connection->send($response);
};

\Workerman\Worker::runAll();
