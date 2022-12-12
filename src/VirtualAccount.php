<?php

namespace Zainpay\SDK;

use GuzzleHttp\Exception\GuzzleException;
use Zainpay\SDK\Lib\RequestTrait;

class VirtualAccount
{
    use RequestTrait;

    /**
     * Get the current wallet balance of a virtual account number
     *
     * @param string $accountNumber
     * @return Response
     * @throws GuzzleException
     * @link https://zainpay.ng/developers/api-endpoints?section=virtual-account-balance
     */
    public function balance(string $accountNumber): Response
    {
        return $this->get($this->getModeUrl() . 'virtual-account/wallet/balance/' . $accountNumber);
    }

    /**
     * Get all transactions of an account
     *
     * @param string $accountNumber
     * @return Response
     * @throws GuzzleException
     * @link https://zainpay.ng/developers/api-endpoints?section=virtual-account-transactions
     */
    public function transactionList(string $accountNumber): Response
    {
        return $this->get($this->getModeUrl() . 'virtual-account/wallet/transactions/' . $accountNumber);
    }

    /**
     * The endpoint can be used to verify a posted transaction by its reference (The txnRef acquired after successful Funds Transfer )
     *
     * @param string $tnxId
     * @return Response
     * @throws GuzzleException
     *
     * @link https://zainpay.ng/developers/api-endpoints?section=transaction-verification
     */
    public function verifyTransfer(string $tnxId): Response
    {
        return $this->get($this->getModeUrl() . 'virtual-account/wallet/transaction/verify/' . $tnxId);
    }

    /**
     * The endpoint can be used to verify a posted transaction by its reference (The txnRef acquired after successful Funds Transfer )
     *
     * @param string $tnxId
     * @return Response
     * @throws GuzzleException
     *
     * @link https://zainpay.ng/developers/api-endpoints?section=transaction-verification
     */
    public function verifyDepositTransaction(string $tnxId): Response
    {
        return $this->get($this->getModeUrl() . 'virtual-account/wallet/deposit/verify/' . $tnxId);
    }

    /**
     * Create a virtual account. Map a virtual account to a zainbox. A zainbox can hold multiple virtual accounts.
     *
     * @param string $firstName
     * @param string $surname
     * @param string $email
     * @param string $dob
     * @param string $gender
     * @param string $address
     * @param string $title
     * @param string $state
     * @param string $zainboxCode
     * @return Response
     * @throws GuzzleException
     *
     * @link https://zainpay.ng/developers/api-endpoints?section=create-virtual-account
     */
    public function createVirtualAccount(
        string $firstName,
        string $surname,
        string $email,
        string $dob,
        string $gender,
        string $address,
        string $title,
        string $state,
        string $zainboxCode
    ): Response
    {
        return $this->post($this->getModeUrl() . 'virtual-account/create/request', [
            'bankType' => "wemaBank",
            'firstName' => $firstName,
            'surname' => $surname,
            'email' => $email,
            'dob' => $dob,
            'gender' => $gender,
            'address' => $address,
            'title' => $title,
            'state' => $state,
            'zainboxCode' => $zainboxCode
        ]);
    }

    /**
     * Activate or deactivate virtual account
     *
     * @param string $zainboxCode
     * @param string $accountNumber
     * @param bool $status
     * @return Response
     * @throws GuzzleException
     *
     * @link https://zainpay.ng/developers/api-endpoints?section=update-virtual-account-status
     */
    public function changeVirtualAccountStatus(
        string $zainboxCode,
        string $accountNumber,
        bool   $status
    ): Response
    {
        return $this->patch($this->getModeUrl() . '/virtual-account/change/account/status', [
            'zainboxCode' => $zainboxCode,
            'accountNumber' => $accountNumber,
            'status' => $status
        ]);
    }

    /**
     * @throws GuzzleException
     */
    public function allVirtualAccountsBalanceOfZainBox(
        String $zainboxCode
    ): Response
    {
        return $this->get($this->getModeUrl(). '/zainbox/accounts/balance/'. $zainboxCode);
    }
}
