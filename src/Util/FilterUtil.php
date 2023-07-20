<?php
namespace Zainpay\SDK\Util;

class FilterUtil
{
    public static function ConstructFilterParams(?string $accountNumber, ?string $txnType, ?string $paymentChannel,  ?string $dateFrom,  ?string $dateTo)

    {
        $params = [];
        (!empty($accountNumber)) ? $params['accountNumber'] = $accountNumber : "";
        (!empty($txnType))       ? $params['txnType'] = $txnType : "";
        (!empty($paymentChannel))       ? $params['paymentChannel'] = $paymentChannel : "";
        (!empty($dateFrom))      ? $params['dateFrom'] = $dateFrom : "";
        (!empty($dateTo))        ? $params['dateTo'] = $dateTo : "";
        return $params;
    }
}
