<?php

namespace Zainpay\SDK\Tests\Classes;

use Zainpay\SDK\Response;
use Zainpay\SDK\Tests\Mockery;

class ZainBox extends \Zainpay\SDK\ZainBox
{
    public function create(
        string $name,
        string $email,
        array $tags,
        string $callbackUrl,
        string $codeNamePrefix = null
    ): Response
    {
        return Mockery::mockResponseFromFile(
            'GET',
            '/',
            dirname(__DIR__) . '/responses/zainbox/create.json'
        );
    }

    public function createDuplicate(string $name, string $email, array $tags, string $callbackUrl): Response
    {
        return Mockery::mockResponseFromFile(
            'GET',
            '/',
            dirname(__DIR__) . '/responses/zainbox/create-duplicate.json'
        );
    }

    public function list(): Response
    {
        return Mockery::mockResponseFromFile(
            'GET',
            '/',
            dirname(__DIR__) . '/responses/zainbox/list.json'
        );
    }

    public function transactionList(string $zainboxCode): Response
    {
        return Mockery::mockResponseFromFile(
            'GET',
            '/',
            dirname(__DIR__) . '/responses/zainbox/transaction-list.json'
        );
    }

    public function merchantTransactionList(): Response
    {
        return Mockery::mockResponseFromFile(
            'GET',
            '/',
            dirname(__DIR__) . '/responses/zainbox/transaction-list.json'
        );
    }

    public function profile(string $zainboxCode): Response
    {
        return Mockery::mockResponseFromFile(
            'GET',
            '/',
            dirname(__DIR__) . '/responses/zainbox/profile.json'
        );
    }

    public function getSettlement(string $zainboxCode): Response
    {
        return Mockery::mockResponseFromFile(
            'GET',
            '/',
            dirname(__DIR__) . '/responses/zainbox/settlements.json'
        );
    }

    public function listVirtualAccounts(string $zainboxCode): Response
    {
        return Mockery::mockResponseFromFile(
            'GET',
            '/',
            dirname(__DIR__) . '/responses/zainbox/virtual-account-list.json'
        );
    }

    public function totalPaymentCollectedByZainbox(string $zainboxCode, ?string $dateFrom = null, ?string $dateTo = null): Response
    {
        return Mockery::mockResponseFromFile(
            'GET',
            '/',
            dirname(__DIR__) . '/responses/zainbox/collected-payments.json'
        );
    }

    public function totalPaymentCollectedByMerchant(string $dateFrom, string $dateTo): Response
    {
        return Mockery::mockResponseFromFile(
            'GET',
            '/',
            dirname(__DIR__) . '/responses/zainbox/collected-payments.json'
        );
    }

    public function createSettlement(string $name, string $zainboxCode, string $scheduleType, string $schedulePeriod, array $settlementAccountList, bool $status): Response
    {
        return Mockery::mockResponseFromFile(
            'GET',
            '/',
            dirname(__DIR__) . '/responses/zainbox/create-settlement.json'
        );
    }
}