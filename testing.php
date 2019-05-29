<?php

require __DIR__ . '/vendor/autoload.php';

$client = new \GuzzleHttp\Client([
    'base_uri' => 'http://localhost:8000', // @todo base_uri in >= v6
    'defaults' => [
        'exceptions' => false,
    ]
]);

$nickname = 'ObjectOrienter' . rand(0, 999);
$data = [
    'nickname'     => $nickname,
    'avatarNumber' => 5,
    'tagLine'      => 'a test dev!'
];

// 1) POST to create the programmer
$response = $client->post('/api/programmers', [
    'body' => json_encode($data)
]);

$programmerUrl = $response->getHeaderLine('Location');

// 2) GET to fetch that programmer
$response = $client->get($programmerUrl);

// 3) GET a collection
$response = $client->get('/api/programmers');

echo 'Status: ' . $response->getStatusCode() . PHP_EOL;
echo 'Content-Type: ' . $response->getHeaderLine('Content-Type') . PHP_EOL;
echo 'Location: ' . $response->getHeaderLine('Location') . PHP_EOL;
echo $response->getBody() . PHP_EOL;