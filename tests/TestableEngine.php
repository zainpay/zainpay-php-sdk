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
        Engine::setToken('eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9');
    }
}