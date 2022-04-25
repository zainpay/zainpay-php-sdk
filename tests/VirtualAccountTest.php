<?php

namespace Zainpay\SDK\Tests;

use GuzzleHttp\Exception\GuzzleException;
use PHPUnit\Framework\TestCase;
use Zainpay\SDK\VirtualAccount;

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
        $lists = (new VirtualAccount())->balance('4427225285');
        self::assertTrue($lists->hasSucceeded());
    }

    /**
     * @throws GuzzleException
     */
    public function testAccountTransactionsList(): void
    {
        $lists = (new VirtualAccount())->transactionList('4427225285');
        self::assertTrue($lists->hasSucceeded());
    }

    /**
     * @throws GuzzleException
     */
    // public function testVerifyTransaction(): void
    // {
    //     $lists = (new VirtualAccount())->verifyTransaction('ovouc');
    //     self::assertTrue($lists->hasSucceeded());
    // }

    /**
     * @throws GuzzleException
     */
    // public function testChangeVirtualAccountStatus(): void
    // {
    //     $lists = (new VirtualAccount())->changeVirtualAccountStatus('0UW8e14g4xJxmxMbHkMy', '4427225285', true);
    //     self::assertTrue($lists->hasSucceeded());
    // }

    /**
     * @throws GuzzleException
     */
    // public function testVirtualAccountCreation(): void
    // {
    //     $zainbox = new VirtualAccount();
    //     $response = $zainbox->createVirtualAccount(
    //         "firstname_" . $this->name,
    //         "surname_" . $this->name,
    //         "test{$this->name}@zainpay.ng",
    //         date("d-m-Y"),
    //         'M',
    //         'address',
    //         'Mr',
    //         'Kano',
    //         '0UW8e14g4xJxmxMbHkMy',
    //     );

    //     self::assertTrue($response->hasSucceeded());
    // }
}
