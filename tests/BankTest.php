<?php

namespace Zainpay\SDK\Tests;

use GuzzleHttp\Exception\GuzzleException;
use PHPUnit\Framework\TestCase;
use Zainpay\SDK\Bank;

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
        $lists = (new Bank())->list();
        self::assertTrue($lists->hasSucceeded());
    }

    /**
     * @return void
     * @throws GuzzleException
     */
    public static function testAccountNameEnquiry(): void
    {
        $lists = (new Bank())->accountNameEnquiry('000015', '4427225285');
        self::assertTrue($lists->hasSucceeded());
    }

    /**
     * TODO: to be commented out when bank list is available
     * @throws GuzzleException
     */
    // public function testTransfer(): void
    // {
    //     $response = (new Bank())->transfer(
    //         "4426334208", 
    //         "000015", 
    //         "5",
    //         "4427225285", 
    //         "000015",
    //         "0UW8e14g4xJxmxMbHkMy", 
    //         time(), 
    //         "Test"
    //     );

    //     self::assertTrue($response->hasSucceeded());
    // }
}
