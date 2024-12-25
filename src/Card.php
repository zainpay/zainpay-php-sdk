<?php

namespace Zainpay\SDK;

use GuzzleHttp\Exception\GuzzleException;
use Zainpay\SDK\Lib\RequestTrait;
use Zainpay\SDK\Util\FilterUtil;

class Card
{
    use RequestTrait;

    /**
     * @throws GuzzleException
     */
    public function initializeCardPayment(
        string $amount,
        string $txnRef,
        string $emailAddress,
        string $mobileNumber,
        string $zainboxCode,
        string $callBackUrl
    ): Response {
        return $this->post($this->getModeUrl() . 'zainbox/card/initialize/payment', [
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
        string $transactionReference
    ): Response {
        return $this->get($this->getModeUrl() . 'virtual-account/wallet/deposit/verify/' . $transactionReference);
    }

    public function verifyCardPaymentV2(
        string $transactionReference
    ): Response {
        return $this->get($this->getModeUrl() . 'virtual-account/wallet/deposit/verify/v2/' . $transactionReference);
    }

    public function reconcileCardPayment(
        string $transactionReference
    ): Response {
        return $this->get($this->getModeUrl() . 'virtual-account/wallet/transaction/reconcile/card-payment', ['txnRef' => $transactionReference]);
    }

    /**
     * Get a list of card transactions from a particular zainbox
     *
     * @param string $zainboxCode
     * @param int $count
     * @param string $dateFrom
     * @param string $dateTo
     * @param string $email
     * @param string $status
     * @param string $txnRef
     * @return Response
     * @throws GuzzleException
     *
     * @link https://zainpay.ng/developers/api-endpoints?section=
     */
    public function zainboxTransactionHistory(string $zainboxCode, int $count = 20, ?string $dateFrom, ?string $dateTo, ?string $email, ?string $status, ?string $txnRef): Response
    {
        return $this->get($this->getModeUrl() . 'zainbox/card/transactions/' . $zainboxCode, FilterUtil::CardTxnHistoryFilterParams(null, $count, $dateFrom, $dateTo, $email, $status, $txnRef));
    }
}
