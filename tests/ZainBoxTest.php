<?php

namespace Zainpay\SDK\Tests;

use GuzzleHttp\Exception\GuzzleException;
use PHPUnit\Framework\TestCase;
use Zainpay\SDK\ZainBox;

class ZainBoxTest extends TestCase
{
    protected static string $name;

    protected function setUp(): void
    {
        TestableEngine::useDummyToken();
    }

    /**
     * @throws GuzzleException
     */
    public function testZainboxCreation(): void
    {
        $time = time();
        static::$name = uniqid();

        $response = (new ZainBox())->create(
            static::$name,
            "test{$time}@zainpay.ng",
            ['food', 'drinks'],
            'https://webhook.example.com'
        );

        self::assertTrue($response->hasSucceeded());
    }

    /**
     * @return void
     * @throws GuzzleException
     */
    public function testListZainBoxes(): void
    {
        $response = (new ZainBox())->list();
        self::assertTrue($response->hasSucceeded());

        $zainboxes = $response->getData();
        $lastZainbox = end($zainboxes);

        self::assertSame(static::$name, $lastZainbox['name']);
        self::assertSame('food,drinks', $lastZainbox['tags']);
    }

    /**
     * @return void
     * @throws GuzzleException
     */
    public function testAllZainboxesTransactionsList(): void
    {
        $response = (new ZainBox())->merchantTransactionList();
        self::assertTrue($response->hasSucceeded());
    }

    /**
     * @return void
     * @throws GuzzleException
     */
    public function testZainboxTransactionsList(): void
    {
        $response = (new ZainBox())->transactionList('0UW8e14g4xJxmxMbHkMy');
        self::assertTrue($response->hasSucceeded());
    }

    /**
     * @return void
     * @throws GuzzleException
     */
    public function testZainboxProfile(): void
    {
        $response = (new ZainBox())->profile('0UW8e14g4xJxmxMbHkMy');
        self::assertTrue($response->hasSucceeded());
    }

    /**
     * @return void
     * @throws GuzzleException
     */
    public function testGetZainboxSettlement(): void
    {
        $response = (new ZainBox())->getSettlement('0UW8e14g4xJxmxMbHkMy');
        self::assertTrue($response->hasSucceeded());
    }

    /**
     * @return void
     * @throws GuzzleException
     */
    public function testZainboxVirtualAccountsList(): void
    {
        $response = (new ZainBox())->listVirtualAccounts('0UW8e14g4xJxmxMbHkMy');
        self::assertTrue($response->hasSucceeded());
    }

    /**
     * @return void
     * @throws GuzzleException
     */
    public function testPaymentCollectedByZainbox(): void
    {
        $response = (new ZainBox())->totalPaymentCollected('0UW8e14g4xJxmxMbHkMy', null, null);
        self::assertTrue($response->hasSucceeded());
    }

    /**
     * @throws GuzzleException
     */
    public function testZainboxSettlementCreation(): void
    {
        $zainbox = new ZainBox();
        $response = $zainbox->createSettlement(
            'settlement_' . static::$name,
            '0UW8e14g4xJxmxMbHkMy',
            'T1',
            'Daily',
            [
                $zainbox->constructSettlementAccountPayload("4427225285", "ZP001", 90),
                $zainbox->constructSettlementAccountPayload("4421566463", "ZP001", 10)
            ],
            true
        );

        self::assertTrue($response->hasSucceeded());
    }
}
