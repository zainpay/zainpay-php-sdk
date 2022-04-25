<?php

use Zainpay\SDK\Engine;

require __DIR__ . '/vendor/autoload.php';

Engine::setMode(Engine::MODE_DEVELOPMENT);
Engine::setToken('eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwczovL3phaW5wYXkubmciLCJpYXQiOjE2NDYxMjg3NzQsImlkIjoyMWQ3MGY3OC1lOThiLTQ1MmQtYWFlMS0zNzJkNDI3ZWVlMzIsIm5hbWUiOm51cmFraWxhdXJlbjFAZ21haWwuY29tLCJyb2xlIjpudXJha2lsYXVyZW4xQGdtYWlsLmNvbSwic2VjcmV0S2V5Ijp3ZnFyOGhSbk5BWWU1blhIc2JQckJ5M2pFYThVaXpZYldCaFlPZFI2M2hodEt9.XNqHeTevO8rzHsJ9M8spje33f4d8bwNxPHFAaurV5cY');

$zainbox = new \Zainpay\SDK\ZainBox();
$bank = new \Zainpay\SDK\Bank();
$virtualAccount = new \Zainpay\SDK\VirtualAccount();


// var_dump($zainbox->listZainboxes());
// var_dump($zainbox->zainboxVirtualAccounts('0UW8e14g4xJxmxMbHkMy'));
// var_dump($zainbox->allZainboxesTransactionsList());
// var_dump($zainbox->zainboxTransactionsList('0UW8e14g4xJxmxMbHkMy'));
// var_dump($zainbox->paymentCollectByZainbox('0UW8e14g4xJxmxMbHkMy',null,null));
// var_dump($zainbox->zainboxProfile('0UW8e14g4xJxmxMbHkMy'));
var_dump($zainbox->getSettlement('0UW8e14g4xJxmxMbHkMy'));
// var_dump($zainbox->createZainboxSettlement(
//     "settleMe",
//     "0UW8e14g4xJxmxMbHkMy",
//     "T1",
//     "Daily",
//     [
//         $zainbox->settlementAccountPayload("4427225285","ZP001",90),
//         $zainbox->settlementAccountPayload("4421566463","ZP001",10)
//     ],
//     true
// ));

// var_dump($bank->listOfBanks());
// var_dump($bank->accountNameEnquiry('000013', '0011242735'));

// var_dump($virtualAccount->balance('4427225285'));
// var_dump($virtualAccount->transactionsList('4427225285'));
// var_dump($virtualAccount->verifyTransaction('YimanWm1axn'));
