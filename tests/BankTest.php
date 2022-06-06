<?php

namespace Zainpay\SDK\Tests;

use GuzzleHttp\Exception\GuzzleException;
use Zainpay\SDK\Tests\Classes\Bank;

class BankTest extends TestCase
{
    protected function setUp(): void
    {
        TestableEngine::useDummyToken();
        parent::setUp();
    }

    /**
     * @throws GuzzleException
     */
    public function testListOfBanks(): void
    {
        $lists = Bank::instantiate()->list();
        self::assertTrue($lists->hasSucceeded());
    }

    /**
     * @return void
     * @throws GuzzleException
     */
    public function testAccountNameEnquiry(): void
    {
        $lists = Bank::instantiate()->accountNameEnquiry(
            $this->faker->unique()->text(),
            $this->faker->randomNumber()
        );

        self::assertTrue($lists->hasSucceeded());
    }

    /**
     * TODO: to be commented out when bank list is available
     * @throws GuzzleException
     */
     public function testTransfer(): void
     {
         $response = Bank::instantiate()->transfer(
             $this->faker->randomNumber(),
             strval($this->faker->randomNumber()),
             strval($this->faker->randomNumber()),
             $this->faker->randomNumber(),
             strval($this->faker->randomNumber()),
             $this->faker->unique()->text(),
             $this->faker->unique()->text(),
             $this->faker->unique()->text()
         );

         self::assertTrue($response->hasSucceeded());
     }
}
