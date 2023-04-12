<?php

namespace Zainpay\SDK;

use Psr\Http\Message\ResponseInterface;

class Response
{
    protected ResponseInterface $response;
    protected array $decodedResponse;


    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
        $this->decodedResponse = json_decode($response->getBody()->getContents(), true);
    }

    public function hasSucceeded(): bool
    {
        return ('200' == $this->getCode()|| '00' == $this->getCode());
    }

    public function hasFailed(): bool
    {
        return !$this->hasSucceeded();
    }

    public function getStatus(): string
    {
        return $this->decodedResponse['status'];
    }

    public function getCode(): string
    {
        return $this->decodedResponse['code'];
    }

    public function getDescription(): string
    {
        return $this->decodedResponse['description'];
    }

    public function getData()
    {
        return $this->decodedResponse['data'] ?? null;
    }

    /**
     * @return ResponseInterface
     */
    public function getResponse(): ResponseInterface
    {
        return $this->response;
    }
}