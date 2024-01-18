<?php

namespace Zainpay\SDK;

use GuzzleHttp\Exception\GuzzleException;
use Zainpay\SDK\Lib\RequestTrait;
use Zainpay\SDK\Util\FilterUtil;

class ZainBox
{
    use RequestTrait;

    /**
     * @param string $name
     * @param string $emailNotification
     * @param array|null $tags
     * @param string $callbackUrl
     * @param string|null $codeNamePrefix
     * @param bool|null $allowAutoInternalTransfer
     * @return Response
     * @throws GuzzleException
     */
    public function create(
        string $name,
        string $emailNotification,
        ?array $tags,
        string $callbackUrl,
        ?string $description,
        ?string $codeNamePrefix,
        ?bool $allowAutoInternalTransfer
    ): Response {

        $payload = [
            'name' => $name,
            'emailNotification' => $emailNotification,
            'callbackUrl' => $callbackUrl
        ];

        (isset($tags)) ? $payload['tags'] = implode(",", $tags) : null;
        (isset($description)) ? $payload['description'] = $description : null;
        (isset($codeNamePrefix)) ? $payload['codeNamePrefix'] = $codeNamePrefix : null;
        (isset($allowAutoInternalTransfer)) ? $payload['allowAutoInternalTransfer'] = $allowAutoInternalTransfer : null;

        return $this->post($this->getModeUrl() . 'zainbox/create/request', $payload);
    }

    /**
     * @param string $name
     * @param string|null $emailNotification
     * @param array|null $tags
     * @param string|null $callbackUrl
     *  @param bool|null $allowAutoInternalTransfer
     * @param string $zainboxCode
     * @return Response
     * @throws GuzzleException
     */
    public function update(
        string  $name,
        ?string $emailNotification,
        ?array  $tags,
        ?string $callbackUrl,
        ?string $description,
        ?bool   $allowAutoInternalTransfer,
        string  $zainboxCode
    ): Response {
        $payload = ['codeName' => $zainboxCode, 'name' => $name];
        (isset($tags)) ? $payload['tags'] = implode(",", $tags) : null;
        (isset($callbackUrl)) ? $payload['callbackUrl'] = $callbackUrl : null;
        (isset($emailNotification)) ? $payload['emailNotification'] = $emailNotification : null;
        (isset($description)) ? $payload['description'] = $description : null;
        (isset($allowAutoInternalTransfer)) ? $payload['allowAutoInternalTransfer'] = $allowAutoInternalTransfer : null;

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
    public function merchantTransactionList($count = 20, ?string $accountNumber, ?string $txnType, ?string $paymentChannel, ?string $dateFrom,  ?string $dateTo): Response
    {
        return $this->get($this->getModeUrl() . 'zainbox/transactions', array_merge(["count" => $count], FilterUtil::ConstructFilterParams($accountNumber, $txnType, $paymentChannel, $dateFrom, $dateTo)));
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
    public function transactionList(string $zainboxCode, int $count = 20, ?string $accountNumber, ?string $txnType, ?string $paymentChannel, ?string $dateFrom,  ?string $dateTo): Response
    {
        return $this->get($this->getModeUrl() . 'zainbox/transactions/' . $zainboxCode . "/" . $count, FilterUtil::ConstructFilterParams($accountNumber, $txnType, $paymentChannel, $dateFrom, $dateTo));
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
    public function transactionHistory(string $zainboxCode, int $count = 20, ?string $accountNumber, ?string $txnType,  ?string $paymentChannel, ?string $dateFrom,  ?string $dateTo): Response
    {
        return $this->transactionList($zainboxCode, $count, $accountNumber, $txnType, $paymentChannel, $dateFrom, $dateTo);
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
    public function virtualAccountTransactionList(string $virtualAccount, $count = 20, ?string $txnType,  ?string $paymentChannel, ?string $dateFrom, ?string $dateTo): Response
    {
        return $this->get($this->getModeUrl() . 'virtual-account/wallet/transactions/' . $virtualAccount . "/" . $count, FilterUtil::ConstructFilterParams(null, $txnType, $paymentChannel, $dateFrom, $dateTo));
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
    ): Response {
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
    public function totalPaymentCollectedByZainbox(string $zainboxCode, ?string $dateFrom, ?string $dateTo): Response
    {
        return $this->get($this->getModeUrl() . 'zainbox/transfer/deposit/summary/' . $zainboxCode, FilterUtil::constructFilterParams(null, null, null, $dateFrom, $dateTo));
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
    public function totalPaymentCollectedByMerchant(?string $dateFrom, ?string $dateTo): Response
    {
        return $this->get($this->getModeUrl() . 'zainbox/transactions/summary', FilterUtil::constructFilterParams(null, null, null, $dateFrom, $dateTo));
    }


    /**
     * @param string $accountNumber
     * @param string $bankCode
     * @param float $percentage
     * @return array
     */
    public function ConstructSettlementAccountPayload(string $accountNumber, string $bankCode, float $percentage)
    {
        return json_encode([
            "accountNumber" => $accountNumber,
            "bankCode"      => $bankCode,
            "percentage"    => strval($percentage),
        ]);
    }
}
