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
     * @param int $accountNumber
     * @return Response
     * @throws GuzzleException
     * @link https://zainpay.ng/developers/api-endpoints?section=name-enquiry
     */
    public function accountNameEnquiry(string $bankCode, int $accountNumber): Response
    {
        return $this->get($this->getModeUrl() . 'bank/name-enquiry', [
            'bankCode' => $bankCode,
            'accountNumber' => strval($accountNumber)
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
     * @param int $destinationAccountNumber
     * @param string $destinationBankCode
     * @param string $amount
     * @param int $sourceAccountNumber
     * @param string $sourceBankCode
     * @param string $zainBoxCode
     * @param string $txnRef
     * @param string $narration
     * @return Response
     * @throws GuzzleException
     * @link https://zainpay.ng/developers/api-endpoints?section=funds-transfer
     */
    public function transfer(
        int    $destinationAccountNumber,
        string $destinationBankCode,
        string $amount,
        int    $sourceAccountNumber,
        string $sourceBankCode,
        string $zainBoxCode,
        string $txnRef,
        string $narration
    ): Response
    {
        return $this->post($this->getModeUrl() . 'bank/transfer', [
            'destinationAccountNumber' => strval($destinationAccountNumber),
            'destinationBankCode' => $destinationBankCode,
            'amount' => $amount,
            'sourceAccountNumber' => strval($sourceAccountNumber),
            'sourceBankCode' => $sourceBankCode,
            'zainBoxCode' => $zainBoxCode,
            'txnRef' => $txnRef,
            'narration' => $narration
        ]);
    }
}
