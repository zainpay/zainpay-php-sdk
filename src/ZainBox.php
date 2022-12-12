<?php

namespace Zainpay\SDK;

use GuzzleHttp\Exception\GuzzleException;
use Zainpay\SDK\Lib\RequestTrait;

class ZainBox
{
    use RequestTrait;

    /**
     * @param string $name
     * @param string $email
     * @param array $tags
     * @param string $callbackUrl
     * @param string|null $codeNamePrefix
     * @return Response
     * @throws GuzzleException
     */
    public function create(
        string $name,
        string $email,
        array $tags,
        string $callbackUrl,
        string $codeNamePrefix = null
    ): Response
    {
        $payload = [
            'name' => $name,
            'email'=> $email,
            'tags' => $tags,
            'callbackUrl' => $callbackUrl,
            'codeNamePrefix' => $codeNamePrefix
        ];

        if($codeNamePrefix != null) {
            $payload['codeNamePrefix'] = $codeNamePrefix;
        }
        return $this->post($this->getModeUrl() . 'zainbox/create/request', [
            $payload
        ]);
    }

    /**
     * @param string $name
     * @param string $emailNotification
     * @param array $tags
     * @param string $callbackUrl
     * @param string $zainboxCode
     * @return Response
     * @throws GuzzleException
     */
    public function update(
        string $name,
        string $emailNotification,
        array  $tags,
        string $callbackUrl,
        string $zainboxCode
    ): Response
    {
        $payload = [
            'name' => $name,
            'emailNotification'=> $emailNotification,
            'tags' => $tags,
            'codeName' => $zainboxCode,
            'callbackUrl' => $callbackUrl
        ];


        return $this->patch($this->getModeUrl() . 'zainbox/update', $payload);
    }

    /**
     * @return Response
     * @throws GuzzleException
     */
    public function list(): Response
    {
        return $this->get($this->getModeUrl() . 'zainbox/list');
    }

    /**
     *  Get the list of first 50 transactions of a merchant
     *
     * @return Response
     * @throws GuzzleException
     *
     * @link https://zainpay.ng/developers/api-endpoints?section=merchant-transactions
     */
    public function merchantTransactionList(): Response
    {
        return $this->get($this->getModeUrl() . 'zainbox/transactions');
    }

    /**
     * Get a list of transactions from a particular zainbox
     *
     * @param string $zainboxCode
     * @return Response
     * @throws GuzzleException
     *
     * @link https://zainpay.ng/developers/api-endpoints?section=zainbox-transactions-history
     */
    public function transactionList(string $zainboxCode): Response
    {
        return $this->get($this->getModeUrl() . 'zainbox/transactions/' . $zainboxCode);
    }

    /**
     * An alias of transactionList()
     *
     * @param string $zainboxCode
     * @return Response
     * @throws GuzzleException
     * @alias transactionList()
     *
     * @link https://zainpay.ng/developers/api-endpoints?section=zainbox-transactions-history
     */
    public function transactionHistory(string $zainboxCode): Response
    {
        return $this->transactionList($zainboxCode);
    }

    /**
     * Get a list of transactions from a particular virtualAccount
     *
     * @param string $virtualAccount
     * @return Response
     * @throws GuzzleException
     *
     * @link https://zainpay.ng/developers/api-endpoints?section=zainbox-transactions-history
     */
    public function virtualAccountTransactionList(string $virtualAccount): Response
    {
        return $this->get($this->getModeUrl() . 'virtual-account/wallet/transactions/' . $virtualAccount);
    }

    /**
     *  Get the complete profile of a Zainbox, including the Current Billing Plan for account to account and interBank transfers respectively
     *
     * @param string $zainboxCode
     * @return Response
     * @throws GuzzleException
     *
     * @link https://zainpay.ng/developers/api-endpoints?section=zainbox-profile
     */
    public function profile(string $zainboxCode): Response
    {
        return $this->get($this->getModeUrl() . 'zainbox/profile/' . $zainboxCode);
    }

    /**
     * For Scheduling Settlement
     *
     * Create a scheduled settlement for a zainbox
     * To create a scheduled settlement for a zainbox., please bear in mind that at any given time, a zainbox can only have one type of settlement.
     * Planned settlements are divided into three categories.
     *
     * Check the docs out for more descriptive information.
     *
     * @param string $name
     * @param string $zainboxCode
     * @param string $scheduleType
     * @param string $schedulePeriod
     * @param array $settlementAccountList
     * @param bool $status
     * @return Response
     * @throws GuzzleException
     *
     * @link https://zainpay.ng/developers/api-endpoints?section=create-settlement
     */
    public function createSettlement(
        string $name,
        string $zainboxCode,
        string $scheduleType,
        string $schedulePeriod,
        array  $settlementAccountList,
        bool   $status
    ): Response
    {
        return $this->post($this->getModeUrl() . 'zainbox/settlement', [
            'name' => $name,
            'zainboxCode' => $zainboxCode,
            'scheduleType' => $scheduleType,
            'schedulePeriod' => $schedulePeriod,
            'settlementAccountList' => $settlementAccountList,
            'status' => $status
        ]);
    }

    /**
     * For getting settlement(s) tied to a zainbox
     *
     * @param string $zainboxCode
     * @return Response
     * @throws GuzzleException
     *
     * @link https://zainpay.ng/developers/api-endpoints?section=get-settlement
     */
    public function getSettlement(string $zainboxCode): Response
    {
        return $this->get($this->getModeUrl() . 'zainbox/settlement', ['zainboxCode' => $zainboxCode]);
    }

    /**
     * This endpoint fetches all current account balances for all virtual accounts in a zainbox.
     *
     * @param string $zainboxCode
     * @return Response
     * @throws GuzzleException
     *
     * @link https://zainpay.ng/developers/api-endpoints?section=zainbox-virtual-accounts-balances
     */
    public function listVirtualAccounts(string $zainboxCode): Response
    {
        return $this->get($this->getModeUrl() . 'zainbox/virtual-accounts/' . $zainboxCode);
    }

    /**
     * Get the sum of total amount collected by all virtual accounts for a particular zainbox in a particular period,
     * for both transfer and deposit transactions
     *
     * @param string $zainboxCode
     * @param string $dateFrom
     * @param string $dateTo
     * @return Response
     * @throws GuzzleException
     *
     * @link https://zainpay.ng/developers/api-endpoints?section=total-payment-by-zainbox
     */
    public function totalPaymentCollectedByZainbox(string $zainboxCode, string $dateFrom , string $dateTo): Response
    {
        $period = "?dateFrom=$dateFrom&dateTo=$dateTo";
        return $this->get($this->getModeUrl() . 'zainbox/transfer/deposit/summary/' . $zainboxCode . $period);
    }

    /**
     * Get the sum of total amount collected by all virtual accounts for a merchant in a particular period,
     * for both transfer and deposit transactions
     *
     * @param string $dateFrom
     * @param string $dateTo
     * @return Response
     * @throws GuzzleException
     *
     * @link https://zainpay.ng/developers/api-endpoints?section=total-payment-by-merchant
     */
    public function totalPaymentCollectedByMerchant(string $dateFrom, string $dateTo): Response
    {
        $period = "?dateFrom=$dateFrom&dateTo=$dateTo";
        return $this->get($this->getModeUrl() . 'zainbox/transfer/deposit/summary'.$period);
    }


    /**
     * @param string $accountNumber
     * @param string $bankCode
     * @param float $percentage
     * @return array
     */
    public function constructSettlementAccountPayload(string $accountNumber, string $bankCode, float $percentage): array
    {
        return [
            "accountNumber" => $accountNumber,
            "bankCode" => $bankCode,
            "percentage" => strval($percentage),
        ];
    }
}
