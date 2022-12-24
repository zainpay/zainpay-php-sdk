<?php

namespace Zainpay\SDK;

use GuzzleHttp\Exception\GuzzleException;
use Zainpay\SDK\Lib\RequestTrait;

class Card
{
    use RequestTrait;

    /**
     * @throws GuzzleException
     */
    public function initializeCardPayment(
        String $amount,
        String $txnRef,
        String $emailAddress,
        String $mobileNumber,
        String $zainboxCode,
        String $callBackUrl
    ): Response
    {
        return $this->post($this->getModeUrl(). 'zainbox/card/initialize/payment',[
            'amount' => $amount,
            'txnRef' => $txnRef,
            'emailAddress' => $emailAddress,
            'mobileNumber' => $mobileNumber,
            'zainboxCode' => $zainboxCode,
            'callBackUrl' => $callBackUrl
        ]);
    }

    /**
     * @throws GuzzleException
     */
    public function verifyCardPayment(
        String $transactionReference
    ): Response
    {
        return $this->get($this->getModeUrl(). 'virtual-account/wallet/deposit/verify/'. $transactionReference);
    }


}