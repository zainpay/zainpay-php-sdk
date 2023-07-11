<?php
namespace Zainpay\SDK\Util;

class FilterUtil
{
    public static function ConstructFilterParams(?string $accountNumber, ?string $txnType,  ?string $dateFrom,  ?string $dateTo)

    {
        $params = [];
        (!empty($accountNumber)) ? $params['accountNumber'] = $accountNumber : "";
        (!empty($txnType))       ? $params['txnType'] = $txnType : "";
        (!empty($dateFrom))      ? $params['dateFrom'] = $dateFrom : "";
        (!empty($dateTo))        ? $params['dateTo'] = $dateTo : "";
        return $params;
    }
}
