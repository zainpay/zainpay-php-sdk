<?php

namespace Zainpay\SDK;

use Psr\Http\Message\ResponseInterface;

class Response
{
    protected ResponseInterface $response;
    protected ?array $decodedResponse;
    protected bool $error = false;
    protected ?string $errorMessage = null;

    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
        $this->decodedResponse = $this->decodeResponse();
    }

    protected function decodeResponse(): ?array
    {
        if ($this->response === null) {
            return null;
        }

        $body = $this->response->getBody()->getContents();

        try {
            $decodedResponse = json_decode($body, true, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException $e) {
            // Log or handle the JSON decoding error as needed
            $decodedResponse = null;
        }

        return $decodedResponse;
    }

    public function hasSucceeded(): bool
    {
        return !$this->error && in_array($this->getCode(), ['200', '00', '21'], true);
    }

    public function hasFailed(): bool
    {
        return $this->error || !$this->hasSucceeded();
    }

    public function getStatus(): string
    {
        return $this->decodedResponse['status'] ?? '';
    }

    public function getCode(): string
    {
        return $this->decodedResponse['code'] ?? '';
    }

    public function getDescription(): string
    {
        return $this->decodedResponse['description'] ?? '';
    }

    public function getData()
    {
        return $this->decodedResponse['data'] ?? null;
    }

    public function getResponse(): ResponseInterface
    {
        return $this->response;
    }

    public function setError(bool $error): self
    {
        $this->error = $error;
        return $this;
    }

    public function setErrorMessage(string $errorMessage): self
    {
        $this->errorMessage = $errorMessage;
        return $this;
    }

    public function hasError(): bool
    {
        return $this->error;
    }

    public function getErrorMessage(): ?string
    {
        return $this->errorMessage;
    }
}
