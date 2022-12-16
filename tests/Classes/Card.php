<?php

namespace Zainpay\SDK\Tests\Classes;

use Zainpay\SDK\Response;
use Zainpay\SDK\Tests\Mockery;

class Card extends \Zainpay\SDK\Card
{
    public function InitializeCardPayment(
        String $amount,
        String $txnRef,
        String $emailAddress,
        String $mobileNumber,
        String $zainboxCode,
        String $callBackUrl
    ): Response
    {
        return Mockery::mockResponseFromFile(
            'POST',
            '/',
            dirname(__DIR__) . '/responses/card/initialize-payment.json'
        );
    }

    public function VerifyCardPayment(
        String $transactionReference
    ): Response
    {
        return Mockery::mockResponseFromFile(
            'GET',
            '/',
            dirname(__DIR__) . '/responses/card/verify-payment.json'
        );
    }
}

