<?php

namespace Zainpay\SDK\Tests;

use GuzzleHttp\Exception\GuzzleException;
use Zainpay\SDK\Tests\Classes\VirtualAccount;

class VirtualAccountTest extends TestCase
{
    protected function setUp(): void
    {
        TestableEngine::useDummyToken();
        parent::setUp();
    }

    /**
     * @throws GuzzleException
     */
    public function testAccountBalance(): void
    {
        $response = VirtualAccount::instantiate()->balance($this->faker->randomNumber());

        self::assertArrayHasKey('balanceAmount', $response->getData() ?? []);
        self::assertTrue($response->hasSucceeded());
    }

    /**
     * @throws GuzzleException
     */
    public function testAccountTransactionsList(): void
    {
        $response = VirtualAccount::instantiate()->transactionList($this->faker->randomNumber());
        self::assertTrue($response->hasSucceeded());
    }

    /**
     * @throws GuzzleException
     */
    public function testVerifyTransaction(): void
    {
        $response = VirtualAccount::instantiate()->verifyTransfer($this->faker->unique()->text());

        self::assertNotEmpty($response->getData());
        self::assertArrayHasKey('amount', $response->getData() ?? []);
        self::assertTrue($response->hasSucceeded());
    }

    /**
     * @throws GuzzleException
     */
    public function testChangeVirtualAccountStatus(): void
    {
        $response = VirtualAccount::instantiate()->changeVirtualAccountStatus(
            $this->faker->unique()->text(),
            $this->faker->randomNumber(),
            true
        );

        self::assertTrue($response->hasSucceeded());
    }

    /**
     * @return void
     * @throws GuzzleException
     */
    public function testVirtualAccountCreation(): void
    {
        $response = VirtualAccount::instantiate()->createVirtualAccount(
            $this->faker->name(),
            $this->faker->name(),
            $this->faker->email(),
            $this->faker->date(),
            ['Male', 'Female'][rand(0, 1)],
            $this->faker->address(),
            $this->faker->title(),
            $this->faker->city(),
            $this->faker->unique()->text(7)
        );

        self::assertTrue($response->hasSucceeded());
        self::assertArrayHasKey('bankName', $response->getData() ?? []);
    }
}
