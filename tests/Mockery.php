<?php

namespace Zainpay\SDK\Tests;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

class Mockery
{
    public static function mock(
        int    $status,
        array  $headers,
        string $body,
        array  $clientOptions = []
    ): Client
    {
        $handler = HandlerStack::create(
            new MockHandler([new Response($status, $headers, $body)])
        );

        return new Client(array_merge(['handler' => $handler], $clientOptions));
    }

    public static function mockResponse(
        string $method,
        string $path,
        string $body,
        int    $status = 200,
        array  $headers = [],
        array  $clientOptions = []
    ): \Zainpay\SDK\Response
    {
        $client = self::mock($status, $headers, $body, $clientOptions);
        $response = $client->request($method, $path);

        return new \Zainpay\SDK\Response($response);
    }

    public static function mockResponseFromFile(
        string $method,
        string $path,
        string $filePath,
        int    $status = 200,
        array  $headers = [],
        array  $clientOptions = []
    ): \Zainpay\SDK\Response
    {
        $body = (string)file_get_contents($filePath);
        $client = self::mock($status, $headers, $body, $clientOptions);
        $response = $client->request($method, $path);

        return new \Zainpay\SDK\Response($response);
    }
}