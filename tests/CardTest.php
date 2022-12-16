<?php

namespace Zainpay\SDK\Tests;

use GuzzleHttp\Exception\GuzzleException;
use Zainpay\SDK\Tests\Classes\Card;


class CardTest extends TestCase
{
    protected function setUp(): void
    {
        TestableEngine::useDummyToken();
        parent::setUp();
    }

    public function testInitializeCardPayment(): void
    {
        $response = Card::instantiate()->initializeCardPayment(
           "1000",
           $this->faker->text(),
           $this->faker->email(),
           $this->faker->phoneNumber(),
           $this->faker->text(),
           $this->faker->url() ,
        );
        self::assertTrue($response->hasSucceeded());
    }

    /**
     * @throws GuzzleException
     */
    public function testVerifyCardPayment()
    {
        $response = Card::instantiate()->VerifyCardPayment(
            $this->faker->text(),
        );
        self::assertTrue($response->hasSucceeded());
    }
}