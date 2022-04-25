<?php

namespace Zainpay\SDK\Tests;

use Zainpay\SDK\Engine;

class TestableEngine extends Engine
{
    protected static function resetToken(): void
    {
        self::$token = '';
    }

    public static function useDummyToken(): void
    {
        Engine::setMode(Engine::MODE_DEVELOPMENT);
        Engine::setToken('eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwczovL3phaW5wYXkubmciLCJpYXQiOjE2NDYxMjg3NzQsImlkIjoyMWQ3MGY3OC1lOThiLTQ1MmQtYWFlMS0zNzJkNDI3ZWVlMzIsIm5hbWUiOm51cmFraWxhdXJlbjFAZ21haWwuY29tLCJyb2xlIjpudXJha2lsYXVyZW4xQGdtYWlsLmNvbSwic2VjcmV0S2V5Ijp3ZnFyOGhSbk5BWWU1blhIc2JQckJ5M2pFYThVaXpZYldCaFlPZFI2M2hodEt9.XNqHeTevO8rzHsJ9M8spje33f4d8bwNxPHFAaurV5cY');
    }
}