<?php

namespace Zainpay\SDK\Tests\Classes;

use Zainpay\SDK\Response;
use Zainpay\SDK\Tests\Mockery;

class Bank extends \Zainpay\SDK\Bank
{
    public function list(): Response
    {
        return Mockery::mockResponseFromFile(
            'GET',
            '/',
            dirname(__DIR__) . '/responses/bank/list.json'
        );
    }

    public function accountNameEnquiry(
        string $bankCode,
        string $accountNumber
    ): Response
    {
        return Mockery::mockResponseFromFile(
            'GET',
            '/',
            dirname(__DIR__) . '/responses/bank/name-enquiry.json'
        );
    }

    public function transfer(
        string $destinationAccountNumber,
        string $destinationBankCode,
        string $amount,
        string $sourceAccountNumber,
        string $sourceBankCode,
        string $zainBoxCode, string $txnRef, string $narration): Response
    {
        return Mockery::mockResponseFromFile(
            'GET',
            '/',
            dirname(__DIR__) . '/responses/bank/name-enquiry.json'
        );
    }
}