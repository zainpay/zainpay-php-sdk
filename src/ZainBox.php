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
     * @return Response
     * @throws GuzzleException
     */
    public function create(
        string $name,
        string $email,
        array  $tags,
        string $callbackUrl
    ): Response
    {
        return $this->post($this->getModeUrl() . 'zainbox/create/request', [
            'name' => $name,
            'email' => $email,
            'tags' => implode(',', $tags),
            'callbackUrl' => $callbackUrl
        ]);
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
     * @param string|null $dateFrom
     * @param string|null $dateTo
     * @return Response
     * @throws GuzzleException
     *
     * @link https://zainpay.ng/developers/api-endpoints?section=total-payment-by-zainbox
     */
    public function totalPaymentCollected(string $zainboxCode, ?string $dateFrom = null, ?string $dateTo = null): Response
    {
        return $this->get($this->getModeUrl() . 'zainbox/transfer/deposit/summary/' . $zainboxCode);
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
