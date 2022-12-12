<?php

namespace Zainpay\SDK\Tests;

use GuzzleHttp\Exception\GuzzleException;
use Zainpay\SDK\Tests\Classes\ZainBox;

class ZainBoxTest extends TestCase
{
    protected static string $name = 'zbuss.Online';

    protected function setUp(): void
    {
        parent::setUp();
        TestableEngine::useDummyToken();
    }

    public function testZainboxCreation(): void
    {
        $response = ZainBox::instantiate()->create(
            $this->faker->email(),
            $this->faker->name(),
            $this->faker->unique()->words(rand(2, 5)),
            $this->faker->url()
        );

        self::assertTrue($response->hasSucceeded());
        self::assertSame(($response->getData() ?? [])['name'], 'test.Onlines');
    }

    public function testZainboxDuplicateCreation(): void
    {
        $response = ZainBox::instantiate()->createDuplicate(
            $this->faker->email(),
            $this->faker->name(),
            $this->faker->unique()->words(rand(2, 5)),
            $this->faker->url()
        );

        self::assertFalse($response->hasSucceeded());
        self::assertTrue($response->hasFailed());
        self::assertSame($response->getStatus(), 'DuplicateRequest');
    }

    /**
     * @return void
     * @throws GuzzleException
     */
    public function testListZainBoxes(): void
    {
        $response = ZainBox::instantiate()->list();

        self::assertTrue($response->hasSucceeded());

        $zainboxes = $response->getData();

        self::assertIsArray($zainboxes);

        if (is_array($zainboxes)) {
            $lastZainbox = end($zainboxes);
            self::assertSame(static::$name, $lastZainbox['name']);
            self::assertSame('food,drinks', $lastZainbox['tags']);
        }
    }

    /**
     * @return void
     * @throws GuzzleException
     */
    public function testAllZainboxesTransactionsList(): void
    {
        $response = ZainBox::instantiate()->merchantTransactionList();

        self::assertTrue($response->hasSucceeded());
        self::assertSame('7964524199', ($response->getData() ?? [])[0]['accountNumber']);
    }

    /**
     * @return void
     * @throws GuzzleException
     */
    public function testZainboxTransactionsList(): void
    {
        $response = ZainBox::instantiate()->transactionList($this->faker->unique()->text());
        self::assertTrue($response->hasSucceeded());
    }

    /**
     * @return void
     * @throws GuzzleException
     */
    public function testZainboxProfile(): void
    {
        $response = ZainBox::instantiate()->profile($this->faker->unique()->text());

        self::assertTrue($response->hasSucceeded());
        self::assertArrayHasKey('zainbox', $response->getData() ?? []);
    }

    /**
     * @return void
     * @throws GuzzleException
     */
    public function testGetZainboxSettlement(): void
    {
        $response = ZainBox::instantiate()->getSettlement($this->faker->unique()->text());

        self::assertTrue($response->hasSucceeded());
    }

    /**
     * @return void
     * @throws GuzzleException
     */
    public function testZainboxVirtualAccountsList(): void
    {
        $response = (new ZainBox())->listVirtualAccounts($this->faker->unique()->text());
        self::assertTrue($response->hasSucceeded());
    }

    /**
     * @return void
     * @throws GuzzleException
     */
    public function testPaymentCollectedByZainbox(): void
    {
        $response = ZainBox::instantiate()->totalPaymentCollectedByZainbox($this->faker->unique()->text());

        self::assertTrue($response->hasSucceeded());
        self::assertNotEmpty($response->getData());
        self::assertArrayHasKey('total', ($response->getData() ?? [])[0]);
    }

    /**
     * @throws GuzzleException
     */
    public function testPaymentCollectedByMerchant(): void
    {
        $response = ZainBox::instantiate()->totalPaymentCollectedByMerchant($this->faker->date("Y-m-d"), $this->faker->date("Y-m-d"));

        self::assertTrue($response->hasSucceeded());
        self::assertNotEmpty($response->getData());
        self::assertArrayHasKey('total', ($response->getData() ?? [])[0]);
    }

    /**
     * @throws GuzzleException
     */
    public function ZainboxSettlementCreation(): void
    {
        $response = ZainBox::instantiate()->createSettlement(
            'settlement_' . static::$name,
            '0UW8e14g4xJxmxMbHkMy',
            'T1',
            'Daily',
            /**@phpstan-ignore-next-line **/
            $this->faker->unique()->words(rand(2, 5)),
            true
        );

        self::assertTrue($response->hasSucceeded());
    }
}
