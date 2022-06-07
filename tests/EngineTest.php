<?php

namespace Zainpay\SDK\Tests;

use PHPUnit\Framework\TestCase;
use Zainpay\SDK\Engine;

class EngineTest extends TestCase
{
    public function testTokenAssignment(): void
    {
        TestableEngine::setToken('test-token');

        self::assertSame('test-token', TestableEngine::getToken());
    }

    public function testDefaultMode(): void
    {
        self::assertSame(Engine::MODE_DEVELOPMENT, TestableEngine::getMode());
        self::assertTrue(false !== strpos(TestableEngine::getUrl(Engine::MODE_DEVELOPMENT), 'sandbox.zainpay.ng'));
    }

    public function testModeAssignment(): void
    {
        TestableEngine::setMode(Engine::MODE_PRODUCTION);

        self::assertSame(Engine::MODE_PRODUCTION, TestableEngine::getMode());
    }

    public function testUrl(): void
    {
        TestableEngine::setMode(Engine::MODE_DEVELOPMENT);
        self::assertTrue(false !== strpos(TestableEngine::getUrl(Engine::MODE_DEVELOPMENT), 'sandbox.zainpay.ng'));

        TestableEngine::setMode(Engine::MODE_PRODUCTION);
        self::assertTrue(false !== strpos(TestableEngine::getUrl(Engine::MODE_PRODUCTION), 'api.zainpay.ng'));
    }
}
