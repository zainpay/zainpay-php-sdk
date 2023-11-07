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
        String $amount,
        String $txnRef,
        String $emailAddress,
        String $mobileNumber,
        String $zainboxCode,
        String $callBackUrl
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
        String $transactionReference
    ): Response {
        return $this->get($this->getModeUrl() . 'virtual-account/wallet/deposit/verify/' . $transactionReference);
    }

    public function verifyCardPaymentV2(
        String $transactionReference
    ): Response {
        return $this->get($this->getModeUrl() . 'virtual-account/wallet/deposit/verify/v2/' . $transactionReference);
    }

    /**
     * Get a list of card transactions from a particular zainbox
     *
     * @param string $zainboxCode
     * @param int $count
     * @param string $dateFrom
     * @param string $dateTo
     * @return Response
     * @throws GuzzleException
     *
     * @link https://zainpay.ng/developers/api-endpoints?section=
     */
    public function zainboxTransactionHistory(string $zainboxCode, int $count = 20, ?string $dateFrom,  ?string $dateTo): Response
    {
        return $this->get($this->getModeUrl() . 'zainbox/card/transactions/' . $zainboxCode, FilterUtil::CardTxnHistoryFilterParams(null, $count, $dateFrom, $dateTo));
    }

    /**
     * Get a list of card transactions by merchant
     *
     * @param string $zainboxCode
     * @param int $count
     * @param string $dateFrom
     * @param string $dateTo
     * @return Response
     * @throws GuzzleException
     *
     * @link https://zainpay.ng/developers/api-endpoints?section=
     */
    public function merchantTransactionHistory(?string $zainboxCode, int $count = 20, ?string $dateFrom,  ?string $dateTo): Response
    {
        return $this->get($this->getModeUrl() . 'zainbox/card/transactions', FilterUtil::CardTxnHistoryFilterParams($zainboxCode, $count, $dateFrom, $dateTo));
    }
}
