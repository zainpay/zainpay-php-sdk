<?php

namespace Zainpay\SDK\Lib;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use UnexpectedValueException;
use Zainpay\SDK\Engine;
use Zainpay\SDK\Response;

trait RequestTrait
{
    private ?int $mode = null;
    private ?string $token = null;


    /**
     * @return static
     */
    public static function instantiate()
    {
        return new static();
    }

    /**
     * @param int $mode
     * @return static
     */
    public function withMode(int $mode)
    {
        $this->mode = $mode;
        return $this;
    }

    public function getModeUrl(): string
    {
        return Engine::getUrl($this->mode);
    }

    /**
     * @param string|null $token
     * @return static
     */
    public function withToken(?string $token)
    {
        $this->token = $token;
        return $this;
    }

    /**
     * @return string
     * @throws UnexpectedValueException
     */
    public function getToken(): string
    {
        $token = $this->token ?? Engine::getToken();

        if (empty($token)) {
            throw new UnexpectedValueException('Please provide token.');
        }

        return $token;
    }


    /**
     * @throws GuzzleException
     * @throws UnexpectedValueException
     */
    public function post(string $url, array $data, array $headers = []): Response
    {
        $client = $this->createClient([
            'headers' => array_merge([
                'Content-type' => 'application/json',
                'Authorization' => "Bearer {$this->getToken()}"
            ], $headers)
        ]);

        $response = $client->post($url, [
            'json' => $data,
        ]);

        return new Response($response);
    }

    /**
     * @throws GuzzleException
     * @throws UnexpectedValueException
     */
    public function get(string $url, array $params = [], array $headers = []): Response
    {
        $client = $this->createClient([
            'headers' => array_merge([
                'Content-type' => 'application/json',
                'Authorization' => "Bearer {$this->getToken()}"
            ], $headers)
        ]);

        $response = $client->get($url, [
            'query' => $params,
        ]);

        return new Response($response);
    }


    /**
     * @throws GuzzleException
     * @throws UnexpectedValueException
     */
    public function patch(string $url, array $data, array $headers = []): Response
    {
        $client = $this->createClient([
            'headers' => array_merge([
                'Content-type' => 'application/json',
                'Authorization' => "Bearer {$this->getToken()}"
            ], $headers)
        ]);

        $response = $client->patch($url, [
            'json' => $data,
        ]);

        return new Response($response);
    }


    protected function createClient(array $config): Client
    {
        return new Client($config);
    }
}