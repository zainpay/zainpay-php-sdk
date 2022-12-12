<?php

namespace Zainpay\SDK\Tests\Classes;

use Zainpay\SDK\Response;
use Zainpay\SDK\Tests\Mockery;

class VirtualAccount extends \Zainpay\SDK\VirtualAccount
{
    public function createVirtualAccount(string $firstName, string $surname, string $email, string $dob, string $gender, string $address, string $title, string $state, string $zainboxCode): Response
    {
        return Mockery::mockResponseFromFile(
            'GET',
            '/',
            dirname(__DIR__) . '/responses/virtual-account/create-account.json'
        );
    }

    public function transactionList(
        string $accountNumber
    ): Response
    {
        return Mockery::mockResponseFromFile(
            'GET',
            '/',
            dirname(__DIR__) . '/responses/zainbox/transaction-list.json'
        );
    }

    public function verifyTransfer(string $tnxId): Response
    {
        return Mockery::mockResponseFromFile(
            'GET',
            '/',
            dirname(__DIR__) . '/responses/virtual-account/transaction-verification.json'
        );
    }

    public function changeVirtualAccountStatus(
        string $zainboxCode,
        string $accountNumber,
        bool $status
    ): Response
    {
        return Mockery::mockResponseFromFile(
            'GET',
            '/',
            dirname(__DIR__) . '/responses/virtual-account/change-virtual-account-status.json'
        );
    }

    public function balance(
        string $accountNumber
    ): Response
    {
        return Mockery::mockResponseFromFile(
            'GET',
            '/',
            dirname(__DIR__) . '/responses/virtual-account/balance.json'
        );
    }
}