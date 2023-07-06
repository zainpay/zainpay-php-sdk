<?php

namespace Zainpay\SDK;

class Engine
{
    protected static string $token = '';
    protected static array $urls = [
        Engine::MODE_DEVELOPMENT => 'https://sandbox.zainpay.ng/',
        Engine::MODE_PRODUCTION => 'https://api.zainpay.ng/',
    ];

    public const MODE_DEVELOPMENT = 0;
    public const MODE_PRODUCTION = 1;

    public static int $chosenMode = Engine::MODE_DEVELOPMENT;


    public static function setMode(int $modeCode): void
    {
        self::$chosenMode = $modeCode;
    }

    public static function getMode(): int
    {
        return self::$chosenMode;
    }

    /**
     * @param string $token
     */
    public static function setToken(string $token): void
    {
        self::$token = $token;
    }

    /**
     * @return string
     */
    public static function getToken(): string
    {
        return self::$token;
    }

    public static function getUrl(?int $mode = null): string
    {
        return self::$urls[$mode ?? self::$chosenMode];
    }
}