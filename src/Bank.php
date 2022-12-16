<?php

namespace Zainpay\SDK;

use GuzzleHttp\Exception\GuzzleException;
use Zainpay\SDK\Lib\RequestTrait;

class Bank
{
    use RequestTrait;

    /**
     * Get the list of available banks.
     *
     * @return Response
     * @throws GuzzleException
     *
     * @link https://zainpay.ng/developers/api-endpoints?section=get-bank-list
     */
    public function list(): Response
    {
        return $this->get($this->getModeUrl() . 'bank/list');
    }

    /**
     * Use the bankCode acquired from the get bank list to validate a bank account number.
     *
     * @param string $bankCode
     * @param string $accountNumber
     * @return Response
     * @throws GuzzleException
     * @link https://zainpay.ng/developers/api-endpoints?section=name-enquiry
     */
    public function accountNameEnquiry(string $bankCode, string $accountNumber): Response
    {
        return $this->get($this->getModeUrl() . 'bank/name-enquiry', [
            'bankCode' => $bankCode,
            'accountNumber' => $accountNumber
        ]);
    }

    /**
     * Fund transfers can be made in the following ways:
     * - Transferring money from one wallet to another
     * - Make a bank account transfer from your wallet.
     *
     * Zainpay infers your fund transfer type, so you don't have to specify it.
     * The charges for each form of transfer are different.
     * This charge can be obtained through your commercials.
     *
     * The amount in the JSON request should be converted to kobo decimalization.
     * It is expected that neither float nor double values will be utilized in this case.
     *
     * @param string $destinationAccountNumber
     * @param string $destinationBankCode
     * @param string $amount
     * @param string $sourceAccountNumber
     * @param string $sourceBankCode
     * @param string $zainBoxCode
     * @param string $txnRef
     * @param string $narration
     * @return Response
     * @throws GuzzleException
     * @link https://zainpay.ng/developers/api-endpoints?section=funds-transfer
     */
    public function transfer(
        string $destinationAccountNumber,
        string $destinationBankCode,
        string $amount,
        string $sourceAccountNumber,
        string $sourceBankCode,
        string $zainBoxCode,
        string $txnRef,
        string $narration
    ): Response
    {
        return $this->post($this->getModeUrl() . 'bank/transfer', [
            'destinationAccountNumber' => $destinationAccountNumber,
            'destinationBankCode' => $destinationBankCode,
            'amount' => $amount,
            'sourceAccountNumber' => $sourceAccountNumber,
            'sourceBankCode' => $sourceBankCode,
            'zainBoxCode' => $zainBoxCode,
            'txnRef' => $txnRef,
            'narration' => $narration
        ]);
    }
}
