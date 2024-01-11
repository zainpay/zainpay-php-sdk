# Zainpay PHP SDK

A PHP API wrapper for [Zainpay](https://zainpay.ng).


## Table of content

- [Getting Started](#requirement)
- [Installation](#installation)
  - [Composer](#installation-via-composer)
  - [Download](#installation-via-download)
- [Usage](#usage)
  - [Example](#usage)
  - [Card Services](#card)
    - [Card Payment Initialiazation](#card-payment-initialization)
    - [Card Payment Verification](#card-payment-verification)
    - [Card Payment Verification V2](#card-payment-verification-v2)
    - [Get Card Transactions By Zainbox](#get-card-tranasactions-by-zainbox)
    - [Get Card Transactions By Merchant (All Zainboxes)](#get-card-tranasactions-for-all-zainboxes)
  - [ZainBox Services](#zainbox)
    - [Create Zainbox](#create-zainbox)
    - [Get All Zainboxes](#create-zainbox)
    - [Update Zainbox](#update-zainbox)
    - [Zainbox Profile And Current Billing Plan](#zainbox-profile-and-current-billing-plan)
    - [Create Or Update  Zainbox Settlement](#create-or-update-zainbox-settlement)
    - [Get Zainbox Settlement](#get-zainbox-settlement)
    - [Get Total Payment Collected By Zainbox](#get-total-payment-collected-by-zainbox)
    - [Get Total Payment Collected For All Zainboxes](#get-total-payment-collected-for-all-zainbox)
    - [Get Zainbox Transaction List](#get-zainbox-transaction-list)
    - [Get Zainbox Virtual Accounts](#get-zainbox-virtual-accounts)
  - [Virtual Account Services](#virtual-account)
    - [Create Virtual Account](#create-virtual-account)
    - [Get Virtual Account Balance](#get-virtual-account-balance)
    - [Update Virtual Account Status](#update-virtual-account-status)
    - [All Virtual Account Balances of a Zainbox](#all-virtual-account-balances-of-a-zainbox)
    - [Virtual Account Transactions](#virtual-account-transactions)
    - [Get All Virtual Account By Zainbox](#get-all-virtual-account-by-zainbox)
    - [Transfer Verification](#transfer-verification)
    - [Deposit Verification](#deposit-verification)
    - [Deposit Verification V2](#deposit-verification-v2)
  - [Bank Services](#zainbox)
    - [Get Bank List](#get-bank-list)
    - [Name Enquiry](#name-enquiry)
    - [Fund Transfer](#fund-transfer)

## Requirements
- Curl (Unless using Guzzle)
- PHP 7.4 or more recent version


## Installation

### Installation Via Composer

```
composer require zainpay/sdk:dev-main
```

### Installation Via download
Download a release version from the [releases page](https://github.com/zainpay/zainpay-php-sdk). Extract, then:
```
 require 'path/to/src/autoload.php';
```

## Usage

This SDK ships with helper class that will help provide global settings for your SDK.<br/>
Further more, methods are provided to help overwrite the globally set configurations within the instantiated request
object.<br/>
The idea of overriding is brought to you for safe usage of this SDK within **async** environment.

**Example: Global settings**

```php
use Zainpay\SDK\Engine;

require __DIR__ . '/vendor/autoload.php';

Engine::setMode(Engine::MODE_DEVELOPMENT);
Engine::setToken('<PUBLIC_KEY>');
```

**Example: Override global settings**

```php
use Zainpay\SDK\Engine;
use Zainpay\SDK\ZainBox;

require __DIR__ . '/vendor/autoload.php';

// Set the mode to development (test server) and provide your public key
Engine::setMode(Engine::MODE_DEVELOPMENT);
Engine::setToken('<PUBLIC_KEY>');

// Alternatively, set the mode to production (live server)
Engine::setMode(Engine::MODE_PRODUCTION);
Engine::setToken('<PUBLIC_KEY>');

// Or use the ZainBox class for more flexibility
ZainBox::instantiate()
    ->withMode(Engine::MODE_PRODUCTION)
    ->withToken('<PUBLIC_KEY>');

```

**Note:**
The Engine class takes in the following parameters:
- **mode** - These are constant values, if set to **Engine::MODE_DEVELOPMENT**, it will use the [sandbox](https://sandbox.zainpay.ng/) API, if set to **Engine::MODE_PRODUCTION**, it will use the [production(live)](https://api.zainpay.ng/) API.
- **token** - This is your public key, which can be found on your [dashboard](https://zainpay.ng/merchant/dashboard/settings).

- For more information about the services exposed by the SDK, please refer to the [documentation](https://zainpay.ng/developers/).

**Response Methods**
* [Response->hasSucceeded()](src/Response.php)   : check if the request has succeeded
* [Response->hasFailed()](src/Response.php)      : check if the request has failed
* [Response->getStatus()](src/Response.php)      : return response status
* [Response->getCode()](src/Response.php)        : return response code
* [Response->getData()](src/Response.php)        : return response data
* [Response->getDescription()](src/Response.php) : return response description
* [Response->getResponse()](src/Response.php)    : return the whole response

How to use Responses:

```php
use Zainpay\SDK\Engine;
use Zainpay\SDK\Card;

require __DIR__ . '/vendor/autoload.php';

Engine::setMode(Engine::MODE_DEVELOPMENT);
Engine::setToken('<PUBLIC_KEY>');

$response = Card::instantiate()->initializeCardPayment(
    '3000',
    'Q6166237864',
    'info@test.com',
    '08000000000',
    'THbfnDvK5o',
    'https://example.net/webhook/zainpay',
);

if ($response->hasSucceeded()){
    var_dump($response->getCode());
    var_dump($response->getStatus());
    var_dump($response->getDescription());
    var_dump($response->getData());
}

if ($response->hasFailed()){
    var_dump($response->getCode());
    var_dump($response->getStatus());
    var_dump($response->getDescription());
    var_dump($response->getData()); //this will return error fields or null if there is no data
}
```

***Response***
```json
        {
            "code": "00",
            "data": "https://dev.zainpay.ng/merchant/redirect-payment?e=V5fvxGjb8wwLvOPZXYyaNMlVZSDrkAdv4ne19X7uiCdqu0kNOOAkMcjbGjApMcivvyLb4vj4azuusyWqC87vtME5n1psVTXai0pIdH61aTdrWJhQFCuYV3a7xJSWiNdDndxh2zNQNl74l2gUpQwhniASWarYUXLl2soyAUAkeAPJ1pUPlTmZddNiYqzgSMhoO1T4OMWk",
            "description": "card processing initialization",
            "status": "200 OK"
        } 
```

***Accessing the response using the response methods***
<!-- if hasSucceeded is true based on the response returned above from zainpay we can be able to access each of the response value using response methods as shown below -->
***$response->getStatus()*** : 
```200 OK```

***$response->getCode()*** : 
```00```

***$response->getDescription()*** : 
```card processing initialization```

***$response->getData()*** : 
```https://dev.zainpay.ng/merchant/redirect-payment?e=V5fvxGjb8wwLvOPZXYyaNMlVZSDrkAdv4ne19X7uiCdqu0kNOOAkMcjbGjApMcivvyLb4vj4azuusyWqC87vtME5n1psVTXai0pIdH61aTdrWJhQFCuYV3a7xJSWiNdDndxh2zNQNl74l2gUpQwhniASWarYUXLl2soyAUAkeAPJ1pUPlTmZddNiYqzgSMhoO1T4OMWk```


## Card

### Card Payment Initialization
- This request enables a merchant to initialize a card payment.
- The **data** field of the response returned is a url which you can redirect your users to visit and make the payment.

    ```php
    use Zainpay\SDK\Engine;
    use Zainpay\SDK\Card;

    require __DIR__ . '/vendor/autoload.php';

    Engine::setMode(Engine::MODE_DEVELOPMENT);
    Engine::setToken('<PUBLIC_KEY>');

    $response = Card::instantiate()->initializeCardPayment(
        '3000',                                 //amount        - required (string)
        'Q6166237864',                          //txnRef        - required (string)
        'info@test.com',                        //payerEmail    - required (string)
        '08000000000',                          //payerMobileNo - required (string)
        'THbfnDvK5o',                           //zainboxCode   - required (string)
        'https://example.net/webhook/zainpay',  //callbackUrl   - required (string)
    );

    if ($response->hasSucceeded()){
        var_dump($response->getData());
    }
    ```

    ***Response***

    ```json
    {
        "code": "00",
        "data": "https://dev.zainpay.ng/merchant/redirect-payment?e=V5fvxGjb8wwLvOPZXYyaNMlVZSDrkAdv4ne19X7uiCdqu0kNOOAkMcjbGjApMcivvyLb4vj4azuusyWqC87vtME5n1psVTXai0pIdH61aTdrWJhQFCuYV3a7xJSWiNdDndxh2zNQNl74l2gUpQwhniASWarYUXLl2soyAUAkeAPJ1pUPlTmZddNiYqzgSMhoO1T4OMWk",
        "description": "card processing initialization",
        "status": "200 OK"
    }```
    
### Card Payment Verification
- The request can be used to verify a funds deposit or card payment 
    Note: it returned only amountAfterCharges
    ```php
    use Zainpay\SDK\Engine;
    use Zainpay\SDK\Card;

    require __DIR__ . '/vendor/autoload.php';

    Engine::setMode(Engine::MODE_DEVELOPMENT);
    Engine::setToken('<PUBLIC_KEY>');

    $response = Card::instantiate()->verifyCardPayment(
        '51328349733' //txnRef - required (string)
    );

    if ($response->hasSucceeded()){
        var_dump($response->getData());
    }
    ```

    ***Response***
    
    ```json
    {
        "code": "00",
        "data": {
            "amount": {
                "amount": 100
            },
            "bankName": "",
            "beneficiaryAccountName": "4427505285",
            "beneficiaryAccountNumber": "4427505285",
            "narration": "Approved by Financial Institution",
            "paymentDate": "2022-08-09T15:56:01.686777",
            "paymentRef": "Z9I8XkNRta1hq2dlmMzlhwQ9F60dLw",
            "sender": "Zainpay Card",
            "senderName": "Zainpay Card",
            "txnDate": "2022-08-09T15:56:01.685982",
            "txnRef": "Q6166237864",
            "txnType": "deposit",
            "zainboxCode": "THbfnDvK5o"
        },
        "description": "successful",
        "status": "200 OK"
    }
    ```

### Card Payment Verification V2
- The request can be used to verify a funds deposit or card payment 
    Note: This has different response from the first one because it will enable you to view depositedAmount, txnChargesAmount and amountAfterCharges

    ```php
    use Zainpay\SDK\Engine;
    use Zainpay\SDK\Card;

    require __DIR__ . '/vendor/autoload.php';

    Engine::setMode(Engine::MODE_DEVELOPMENT);
    Engine::setToken('<PUBLIC_KEY>');

    $response = Card::instantiate()->verifyCardPaymentV2(
        '<Transaction-Reference>' //txnRef - required (string)
    );

    if ($response->hasSucceeded()){
        var_dump($response->getData());
    }
    ```
    ***Response***

    ```json
    {
        "code": "00",
        "data": {
            "depositedAmount": "100000",
            "txnChargesAmount": "6400",
            "amountAfterCharges": "93600",
            "bankName": "ZainMFB",
            "beneficiaryAccountName": "idris",
            "beneficiaryAccountNumber": "7964524199",
            "narration": "gift",
            "paymentDate": "2021-12-28T11:48:35.044886444",
            "paymentRef": "a1oA0ws127quism",
            "sender": "900989098",
            "senderName": "hassan ",
            "txnDate": "2021-12-28T11:48:35.044777507",
            "txnRef": "730003356",
            "txnType": "deposit",
            "zainboxCode": "xmaldoaYnakaAAVOAE",
            "callBackUrl": "http://gofundme.ng/webhook",
            "emailNotification": "user@user.com",
            "zainboxName": "users",
            
        },
        "description": "successful",
        "status": "200 OK"
    }
    ```



### Get Card Transactions By Zainbox

    ```php
    use Zainpay\SDK\Engine;
    use Zainpay\SDK\Card;

    require __DIR__ . '/vendor/autoload.php';

    Engine::setMode(Engine::MODE_DEVELOPMENT);
    Engine::setToken('<PUBLIC_KEY>');

    $response = Card::instantiate()->zainboxTransactionHistory(
        'THbxyfjkd20',  //zainboxCode -  required (string)
        20,             //count       -  required (int)         : specify how many records you want to return  
        '2023-11-01',   //dateFrom    -  optional (string|null) : specify start date 
        '2023-11-30'    //dateTo      -  optional (string|null) : specify end date
    );

    if ($response->hasSucceeded()){
        var_dump($response->getData());
    }
    ```
    ***Response***

    ```json
    {
        "code": "00",
        "data": [
            {
                "amount": "19900.0",
                "cardLastFourDigits": "",
                "cardType": "others",
                "paymentRef": "dVE8Dsh4brW3FNAJa5REEvnhICHmU9",
                "settledAccountNumber": "7966884043",
                "txnDate": "2023-10-03T12:10:08",
                "txnRef": "txn_0065004100",
                "txnStatus": "success",
                "zainboxCode": "THbfnDvK5o"
            },
            {
                "amount": "19900.0",
                "cardLastFourDigits": "",
                "cardType": "others",
                "paymentRef": "uisygRZV6xzH0yYVuRzBp7dlXQ3bfC",
                "settledAccountNumber": "7966884043",
                "txnDate": "2023-10-03T11:28:53",
                "txnRef": "txn_0065004099",
                "txnStatus": "success",
                "zainboxCode": "THbfnDvK5o"
            },
        ],
        "description": "successful",
        "status": "200 OK"
    }
    ```

### Get Card Transactions For All Zainboxes

    ```php
    use Zainpay\SDK\Engine;
    use Zainpay\SDK\Card;

    require __DIR__ . '/vendor/autoload.php';

    Engine::setMode(Engine::MODE_DEVELOPMENT);
    Engine::setToken('<PUBLIC_KEY>');

    $response = Card::instantiate()->merchantTransactionHistory(
        null,           //zainboxCode - optional (string|null)  : filter by zainboxCode or null to return all zainboxes
        20,             //count       - required (int), specify : how many records you want to return  
        null,           //dateFrom    - optional (string|null)  : specify start date 
        null            //dateTo      - optional (string|null)  : specify end date
    );

    if ($response->hasSucceeded()){
        var_dump($response->getData());
    }
    ```
    ***Response***

    ```json
    {
        "code": "00",
        "data": [
            {
                "amount": "19900.0",
                "cardLastFourDigits": "",
                "cardType": "others",
                "paymentRef": "dVE8Dsh4brW3FNAJa5REEvnhICHmU9",
                "settledAccountNumber": "7966884043",
                "txnDate": "2023-10-03T12:10:08",
                "txnRef": "txn_0065004100",
                "txnStatus": "success",
                "zainboxCode": "THbfnDvK5o"
            },
            {
                "amount": "19900.0",
                "cardLastFourDigits": "",
                "cardType": "others",
                "paymentRef": "uisygRZV6xzH0yYVuRzBp7dlXQ3bfC",
                "settledAccountNumber": "7966884043",
                "txnDate": "2023-10-03T11:28:53",
                "txnRef": "txn_0065004099",
                "txnStatus": "success",
                "zainboxCode": "THbfnDvK5o"
            },
        ],
        "description": "successful",
        "status": "200 OK"
    }```

## Zainbox

### Create Zainbox

- A zainbox is a virtual bucket that allows a merchant to create unlimited multiple virtual accounts.
- This request enables a merchant to create a zainbox.

    ```php
        use Zainpay\SDK\Engine;
        use Zainpay\SDK\ZainBox;

        require __DIR__ . '/vendor/autoload.php';

        Engine::setMode(Engine::MODE_DEVELOPMENT);
        Engine::setToken('<PUBLIC_KEY>');

        $response = ZainBox::instantiate()->create(
            "Box Test 1",                   //name                      - required (string),
            "test@email.com",               //emailNotification         - required (string),
            ['php','sdk'],                  //tags                      - optional (array|null)
            "https://example.com/webhook",  //callbackUrl               - required (string)
            "description",                  //description               - optional (string|null) 
            "Test",                         //codeNamePrefix            - optional (string|null) - prefix that you want to add to the codeName for easy identification 
            false                           //allowAutoInternalTransfer - optional (bool|null) - if set to true, whenever money is deposited on any of the zainbox VAs it will be automatically transferred to settlement account.
        );


        if ($response->hasSucceeded()){
            var_dump($response->getData());
        }
    ```

    ***Response***
    ```json
    {
        "status": "Success",
        "description": "successful",
        "data": {
            "codeName": "333_zB2lg6lJtcGzP5XqouN9",
            "name": "wecode-contribution"
        }
    }
    ```

### Get All Zainboxes
- This request enables a merchant to get all your created zainboxes.

    ```php
    use Zainpay\SDK\Engine;
    use Zainpay\SDK\ZainBox;

    require __DIR__ . '/vendor/autoload.php';

    Engine::setMode(Engine::MODE_DEVELOPMENT);
    Engine::setToken('<PUBLIC_KEY>');

    $response = ZainBox::instantiate()->list();

    if ($response->hasSucceeded()){
        var_dump($response->getData());
    }
    ```
    ***Response***
    ```json
    {
        "code": "00",
        "data": [
            {
                "callbackUrl": "http://10e1-41-184-106-54.ngrok.io/notification",
                "codeName": "THbfnDvK5o",
                "name": "test-box",
                "tags": "land, management"
            },
            {
                "callbackUrl": "https://powershop.ng/notification",
                "codeName": "rAqwjnYO5chL3QuV7yk0",
                "name": "powershop8",
                "tags": "discos, kedco, aedc"
            }
        ],
        "description": "successful",
        "status": "Success"
    }
    ```

### Update Zainbox

- Enables you to update zainbox details like callbackUrl, emailNotification & so on
- Note you cannot update zainboxCode.

    ```php
    use Zainpay\SDK\Engine;
    use Zainpay\SDK\ZainBox;

    require __DIR__ . '/vendor/autoload.php';

    Engine::setMode(Engine::MODE_DEVELOPMENT);
    Engine::setToken('<PUBLIC_KEY>');

    string  $name,
            ?string $emailNotification,
            ?array  $tags,
            ?string $callbackUrl,
            ?string $description,
            ?bool   $allowAutoInternalTransfer,
            string  $zainboxCode

    $response = ZainBox::instantiate()->update(
        "Box Test 1",                   //name                      - required (string),
        "test@email.com",               //emailNotification         - required (string|null),
        ['php','sdk'],                  //tags                      - optional (array|null)
        "https://example.com/webhook",  //callbackUrl               - required (string)
        "description",                  //description               - optional (string|null) 
        false                           //allowAutoInternalTransfer - optional (bool|null) : if set to true, whenever money is deposited on any of the zainbox VAs it will be automatically transferred to settlement account.
        "zainboxCode",                 //zainboxCode                - required (string)
    );


    if ($response->hasSucceeded()){
        var_dump($response->getData());
    }
    ```

    ***Response***
    ```json
    {
        "status": "Success",
        "description": "successful",
        "data": {
            "codeName": "333_zB2lg6lJtcGzP5XqouN9",
            "name": "wecode-contribution"
        }
    } 
    ```

### Zainbox Profile and Current Billing Plan
- Get the complete profile of a Zainbox, including the Current Billing Plan for account to account and interBank transfers respectively

    ```php
    use Zainpay\SDK\Engine;
    use Zainpay\SDK\ZainBox;

    require __DIR__ . '/vendor/autoload.php';

    Engine::setMode(Engine::MODE_DEVELOPMENT);
    Engine::setToken('<PUBLIC_KEY>');

    $response = ZainBox::instantiate()->profile(
        '<ZainboxCode>' //zainboxCode - required (string)
    );

    if ($response->hasSucceeded()){
        var_dump($response->getData());
    }
    ```
    ***Response***
    ```json
    {
        "code": "00",
        "description": "successful",
        "status": "Success",
        "data": {
            "zainbox": {
                "callbackUrl": "http://localhost:5000/notification",
                "codeName": "THbfnDvK5o",
                "name": "test-box",
                "tags": "land, management"
            },
            "account2AccountBilling": {
                "fixedCharge": "1000",
                "percentageCharge": 1.5
            },
            "interBankBilling": {
                "fixedCharge": "5000.0",
                "percentageCharge": 1.4
            }
        }
        
    }```

### Create Or Update  Zainbox Settlement
- This request enables a merchant to create a scheduled settlement for a zainbox. To create a scheduled settlement for a zainbox., please bear in mind that at any given time, a zainbox can only have one type of settlement.

Planned settlements are divided into three categories:
- T1: **Transaction plus one working day** The value of the T1 schedule. The period must always be on a daily basis.
- T2: **Trasaction plus 7 days** Transaction plus seven days for T7 schedule should be one of Monday, Tuesday, Wednesday, Thursday, Friday, Saturday, or Sunday.
- T3: **Transaction plus 30 days** The schedule Period value for T30 should be 1 - 30 or lastDayOfMonth

***Important Note**
- Days like February 28th and February 29th, as well as months with only 30 days, will be covered by lastDayOfMonth.

The payload's settlementAccountList parameter is an array/list of bank accounts with their corresponding settlement percentages.

- set status to false to disable the auto-settlement

***Scenario:***
- Let's say you have a zainbox with three virtual accounts, and you want to set it up so that the total deposits in these three virtual accounts are split between two accounts at every Transaction plus one day (T1). The first settlement account has 90% of the funds, whereas the second contains only 10%.

    ```php
    use Zainpay\SDK\Engine;
    use Zainpay\SDK\ZainBox;

    require __DIR__ . '/vendor/autoload.php';

    Engine::setMode(Engine::MODE_DEVELOPMENT);
    Engine::setToken('<PUBLIC_KEY>');

    $response = ZainBox::instantiate()->createSettlement(
            'new-daily-settlement',//name - required (string)
            'THbfnDvK5op',         //zainboxCode - required (string)
            'T1',                  //scheduleType  - required (string)
            'Daily',               //schedulePeriod - required (string)
            [                      //settlementAccountList required (array) : contains list of ConstructSettlementAccountPayload
                ConstructSettlementAccountPayload(
                    "1234567890", //accountNumber - required (string)
                    "0009",       //bankCode      - required (string)
                    "90"          //percentage    - required (float)
                ),
                ConstructSettlementAccountPayload(
                    "0234567892", //accountNumber - required (string)
                    "0020",       //bankCode      - required (string)
                    "10"          //percentage    - required (float)
                ),
            ],                   
            true,                //status required (bool)
    );

    if ($response->hasSucceeded()){
        var_dump($response->getData());
    }
    ```
    ***Response***
    ```json
    {
        "code": "00",
        "description": "successful",
        "status": "200 OK"
    }```

### Get Zainbox Settlement
- This request enables a merchant to get settlement(s) tied to a zainbox

    ```php
    use Zainpay\SDK\Engine;
    use Zainpay\SDK\ZainBox;

    require __DIR__ . '/vendor/autoload.php';

    Engine::setMode(Engine::MODE_DEVELOPMENT);
    Engine::setToken('<PUBLIC_KEY>');

    $response = ZainBox::instantiate()->getSettlement(
        '<zainboxCode>' //zainboxCode - required (string)
    );

    if ($response->hasSucceeded()){
        var_dump($response->getData());
    }
    ```
    ***Response***
    ```json
    {
        "code": "00",
        "data": {
            "name": "new-daily-settlement3",
            "schedulePeriod": "Daily",
            "scheduleType": "T1",
            "settlementAccounts": [
                {
                    "accountNumber": "4424699900",
                    "bankCode": "000017",
                    "percentage": "50"
                },
                {
                    "accountNumber": "4429775715",
                    "bankCode": "000017",
                    "percentage": "50"
                }
            ],
            "zainbox": "settl_W5HMsiwQB3HdtCbvUnBN"
        },
        "description": "Successful",
        "status": "200 OK"
    }
    ```

### Get Total Payment Collected By Zainbox
- Get the sum of total amount collected by all virtual accounts for a particular zainbox in a particular period, for both transfer and deposit transactions

    **Parameter:** zainboxCode (Required), dateFrom (optional, if not provided, the system returns the data of the current month), dateTo (optional)
    

    ```php
    use Zainpay\SDK\Engine;
    use Zainpay\SDK\ZainBox;

    require __DIR__ . '/vendor/autoload.php';

    Engine::setMode(Engine::MODE_DEVELOPMENT);
    Engine::setToken('<PUBLIC_KEY>');

    $response = Card::instantiate()->totalPaymentCollectedByZainbox(
        'THbxyfjkd20',  //zainboxCode -  required (string)
        '2022-02',      //dateFrom    -  optional (string|null) : specify start date 
        '2022-03'       //dateTo      -  optional (string|null) : specify end date
    );

    if ($response->hasSucceeded()){
        var_dump($response->getData());
    }
    ```
    ***Response***

    ```json
    {
    "code": "00",
    "data": [
    {
        "count": 4,
        "dateFrom": "2022-02",
        "dateTo": "2022-03",
        "total": "12690",
        "transactionType": "deposit"
    },
        {
        "count": 4,
        "dateFrom": "2022-02",
        "dateTo": "2022-03",
        "total": "29038",
        "transactionType": "transfer"
    }
    ],
    "description": "Summary grouped by txn type",
    "status": "Success"
    }
    ```

### Get Total Payment Collected For All Zainboxes
- Get the sum of total amount collected by all virtual accounts for all zainboxes in a particular period, for both transfer and deposit transactions


    ```php
    use Zainpay\SDK\Engine;
    use Zainpay\SDK\ZainBox;

    require __DIR__ . '/vendor/autoload.php';

    Engine::setMode(Engine::MODE_DEVELOPMENT);
    Engine::setToken('<PUBLIC_KEY>');

    $response = Card::instantiate()->totalPaymentCollectedByMerchant(
        '2022-02',   //dateFrom    -  optional (string|null) : specify start date 
        '2022-03'    //dateTo      -  optional (string|null) : specify end date
    );

    if ($response->hasSucceeded()){
        var_dump($response->getData());
    }
    ```
    ***Response***

    ```json
    {
    "code": "00",
    "data": [
    {
        "count": 4,
        "dateFrom": "2022-02",
        "dateTo": "2022-03",
        "total": "12690",
        "transactionType": "deposit"
    },
        {
        "count": 4,
        "dateFrom": "2022-02",
        "dateTo": "2022-03",
        "total": "29038",
        "transactionType": "transfer"
    }
    ],
    "description": "Summary grouped by txn type",
    "status": "Success"
    }
    ```

### Get Zainbox Transaction List

- This request enables you to Get a list of transactions from a particular zainbox

    ```php
    use Zainpay\SDK\Engine;
    use Zainpay\SDK\ZainBox;

    require __DIR__ . '/vendor/autoload.php';

    Engine::setMode(Engine::MODE_DEVELOPMENT);
    Engine::setToken('<PUBLIC_KEY>');

    $response = ZainBox::instantiate()->transactionList(
        'zainboxCode',             //zainboxCode    - required (string)
        20,                        //count          - required (int)         : number of transactions you want to return
        '4426334208',              //accountNumber  - optional (string|null) : use to filter transactions ortherwise use null value.
        'deposit',                 //txnType        - optional (string|null) : use to filter transactions ortherwise use null value. e.g [deposit|transfer]
        'virtualAccountTransfer',  //paymentChannel - optional (string|null) : use to filter transactions ortherwise use null value. e.g [cardPayment|virtualAccountTransfer]
        null,                      //dateFrom       - optional (string|null) : use to filter transactions ortherwise use null value.
        null,                      //dateTo         - optional (string|null) : use to filter transactions ortherwise use null value.
    );

    if ($response->hasSucceeded()){
        var_dump($response->getData());
    }
    ```
    ***Response***
    ```json
    {
        "code": "00",
        "data": [
        {
            "accountNumber": "7964524199",
            "amount": 45000,
            "balance": 45000,
            "narration": "",
            "transactionDate": "2021-12-28T11:47:45",
            "transactionRef": "",
            "transactionType": "deposit"
        },
        {
            "accountNumber": "7964524199",
            "amount": 923000,
            "balance": 968000,
            "narration": "",
            "transactionDate": "2021-12-28T11:48:35",
            "transactionRef": "",
            "transactionType": "deposit"
        }],
        "description": "successful",
        "status": "Success"
    }
    ```

### Get Zainbox Virtual Accounts
- This request enables you to get all virtual accounts linked to a zainbox.

    ```php
    use Zainpay\SDK\Engine;

    require __DIR__ . '/vendor/autoload.php';

    Engine::setMode(Engine::MODE_DEVELOPMENT);
    Engine::setToken('<PUBLIC_KEY>');
    $response = \Zainpay\SDK\ZainBox::instantiate()->listVirtualAccounts(
    '<zainboxCode>' //zainboxCode - required (string)
    );
    if ($response->hasSucceeded()){
        var_dump($response->getData());
    }
    ```

    ***Response***
    ```json
        [
            {
                "bankAccount": "4426334208",
                "bankName": "035",
                "name": "John Saminu Sunday"
            },
            {
                "bankAccount": "7969472891",
                "bankName": "035",
                "name": "Idris Urmi Bello"
            }
        ]
    ```

## Virtual Account

### Create Virtual Account
- Create a virtual account. Map a virtual account to a zainbox. A zainbox can hold multiple virtual accounts.

    ```php
    use Zainpay\SDK\Engine;
    use Zainpay\SDK\VirtualAccount;

    require __DIR__ . '/vendor/autoload.php';

    Engine::setMode(Engine::MODE_DEVELOPMENT);
    Engine::setToken('<PUBLIC_KEY>');
    $response = VirtualAccount::instantiate()->createVirtualAccount(
        'Nura'                          //firstName     - required (string)
        'Yusuf'                         //surname       - required (string)
        'test@gmail.com'                //email         - required (string)
        '08012345678'                   //mobileNumber  - required (string)
        '12-08-1999'                    //dob           - required (string)
        'M'                             //gender        - required (string)
        'No 21 AA Rufai street, Kano'   //address       - required (string)
        'Mr'                            //title         - required (string)
        'Kano'                          //state         - required (string)
        'zainboxCode'                   //zainboxCode   - required (string)
    );

    if ($response->hasSucceeded()){
        var_dump($response->getData());
    }
    ```

    ***Response***
    ```json
    {
    "code": "00",
    "data": {
        "accountName": "Nura Yusuf ",
        "accountNumber": "4426334208", 
        "accountType": "",
        "bankName": "wemaBank",
        "email": "test@gmail.com"
    },
    "description": "Successful",
    "status": "Success"
    }
    ```

### Get Virtual Account Balance
- This request enables you to get the current wallet balance of a virtual account number

    ```php
    use Zainpay\SDK\Engine;
    use Zainpay\SDK\VirtualAccount;

    require __DIR__ . '/vendor/autoload.php';

    Engine::setMode(Engine::MODE_DEVELOPMENT);
    Engine::setToken('<PUBLIC_KEY>');

    $response = VirtualAccount::instantiate()->balance(
    '7966884043' //virtualAccoutNumber - required (string)
    );
    if ($response->hasSucceeded()){
        var_dump($response->getData());
    }
    ```

    ***Response***
    ```json
    {
        "code": "00",
        "data":
        {
            "accountName": "Aminu Nasar Adam", 
            "accountNumber": "7966884043", 
            "balanceAmount": 372555, 
            "transactionDate": "2021-10-13T13:45:52" 
        }, 
        "description": "successful",
        "status": "Success" 
    }
    ```
    
### Update Virtual Account Status

- This request enables you to Activate or deactivate virtual account.
- NOTE: Setting the status field to true will activate the virtual account, while setting it to false will deactivate it.

    ***Important Note***
    A deactivated virtual account will not be able to receive or transfer funds

    ```php
    use Zainpay\SDK\Engine;
        use Zainpay\SDK\VirtualAccount;


    require __DIR__ . '/vendor/autoload.php';

    Engine::setMode(Engine::MODE_DEVELOPMENT);
    Engine::setToken('<PUBLIC_KEY>');

    $response = VirtualAccount::instantiate()->listVirtualAccounts(
    'zainboxCode', //zainboxCode - required (string)
    '7966884043',  //virtualAccoutNumber - required (string)
    true           //status - required (boolean)
    );
    if ($response->hasSucceeded()){
        var_dump($response->getData());
    }
    ```
 
    ***Response***
    ```json
        {
            "code": "00",
            "description": "Successfully Updated Account",
            "status": "success"
        }
    ```


### All Virtual Account Balances of a Zainbox
- This request enables a merchant to fetches all current account balances for all virtual accounts in a zainbox.
    
    ```php
    use Zainpay\SDK\Engine;
    use Zainpay\SDK\VirtualAccount;


    require __DIR__ . '/vendor/autoload.php';

    Engine::setMode(Engine::MODE_DEVELOPMENT);
    Engine::setToken('<PUBLIC_KEY>');

    $response = VirtualAccount::instantiate()->allVirtualAccountsBalanceOfZainBox(
    'zainboxCode' //zainboxCode - required (string)
    );

    if ($response->hasSucceeded()){
        var_dump($response->getData());
    }
    ```
    
    ***Response***
    ```json
    {
    "code": "00",
    "data":  
    [
        {
        "accountName": "Aminu Nasar",
        "accountNumber": "7966884043",
        "balanceAmount": 372555,
        "transactionDate": "2021-10-13T13:45:52"
        },
        {
        "accountName": "Khalid Ali Sani",
        "accountNumber": "1234567890",
        "balanceAmount": 200,
        "transactionDate": "2021-12-13T13:45:52"
        },
        {
        "accountName": "Nura Bala Usman",
        "accountNumber": "9900778833",
        "balanceAmount": 105000,
        "transactionDate": "2022-01-29T13:45:52"
        }
    ],
    "description": "successful",
    "status": "Success"
    }                 
    ```

### Virtual Account Transactions
- This request eanbles you to get all transactions of an account

    ```php
    use Zainpay\SDK\Engine;
    use Zainpay\SDK\VirtualAccount;


    require __DIR__ . '/vendor/autoload.php';

    Engine::setMode(Engine::MODE_DEVELOPMENT);
    Engine::setToken('<PUBLIC_KEY>');

    $response = ZainBox::instantiate()->transactionList(
        'zainboxCode',             //accountNumber  - required (string)
        20,                        //count          - required (int)         : number of transactions you want to return
        'deposit',                 //txnType        - optional (string|null) : use to filter transactions ortherwise use null value. e.g [deposit|transfer]
        'virtualAccountTransfer',  //paymentChannel - optional (string|null) : use to filter transactions ortherwise use null value. e.g [cardPayment|virtualAccountTransfer]
        null,                      //dateFrom       - optional (string|null) : use to filter transactions ortherwise use null value.
        null,                      //dateTo         - optional (string|null) : use to filter transactions ortherwise use null value.
    );

    if ($response->hasSucceeded()){
        var_dump($response->getData());
    }
    ```

    ***Response***
    ```json
    {
        "code": "00",
        "data": 
        [
        {
            "accountNumber": "7966884043",
            "destinationAccountNumber": "2000002105",
            "amount": 7289,
            "balance": 379844,
            "narration": "",
            "transactionDate": "2021-10-13T13:41:39",
            "transactionRef": "",
            "transactionType": "transfer"
        },
        {
            "accountNumber": "7966884043",
            "destinationAccountNumber": "1234567890",
            "amount": 7289,
            "balance": 372555,
            "narration": "",
            "transactionDate": "2021-10-13T13:45:52",
            "transactionRef": "",
            "transactionType": "transfer"
        }
        ],
            "description": "successful",
            "status": "Success"
    }  
    ```

### Get All Virtual Account By Zainbox
- Get all virtual accounts linked to a zainbox

    ```php
    use Zainpay\SDK\Engine;
    use Zainpay\SDK\VirtualAccount;

    require __DIR__ . '/vendor/autoload.php';

    Engine::setMode(Engine::MODE_DEVELOPMENT);
    Engine::setToken('<PUBLIC_KEY>');
    $response = \Zainpay\SDK\ZainBox::instantiate()->listVirtualAccounts(
    '<zainboxCode>' //zainboxCode - required (string)
    );
    if ($response->hasSucceeded()){
        var_dump($response->getData());
    }
    ```

    ***Response***
    ```json
        {
        "code": "00",
        "data":  
        [
            {
            "accountName": "Aminu Nasar",
            "accountNumber": "7966884043",
            "balanceAmount": 372555,
            "transactionDate": "2021-10-13T13:45:52"
            },
            {
            "accountName": "Khalid Ali Sani",
            "accountNumber": "1234567890",
            "balanceAmount": 200,
            "transactionDate": "2021-12-13T13:45:52"
            },
            {
            "accountName": "Nura Bala Usman",
            "accountNumber": "9900778833",
            "balanceAmount": 105000,
            "transactionDate": "2022-01-29T13:45:52"
            }
        ],
        "description": "successful",
        "status": "Success"
    }   
    ```

### Transfer Verification
- The request can be used to verify a posted transfer by its txnRef acquired after successful Funds Transfer

   **Parameter:** txnRef(required).

    ```php
    use Zainpay\SDK\Engine;
    use Zainpay\SDK\VirtualAccount;

    require __DIR__ . '/vendor/autoload.php';

    Engine::setMode(Engine::MODE_DEVELOPMENT);
    Engine::setToken('<PUBLIC_KEY>');

    $response = VirtualAccount::instantiate()->verifyTransfer(
        '<Transaction-Reference>' //txnRef - required (string)
    );

    if ($response->hasSucceeded()){
        var_dump($response->getData());
    }
    ```

    ***Response***
    ```json
    {
        "code": "00",
        "data": {
            "amount": "8431",
            "destinationAccountNumber": "0044159752",
            "destinationBankCode": "000005",
            "narration": "lunch for naimat",
            "sourceAccountNumber": "7964524199",
            "txnDate": "2021-12-29T08:00:49",
            "txnStatus": "success"
        },
        "description": "successful",
        "status": "Success"
    }
    ```

### Deposit Verification
- The request can be used to verify a funds deposit or card payment 
    Note: it returned only amountAfterCharges
    ```php
    use Zainpay\SDK\Engine;
    use Zainpay\SDK\VirtualAccount;

    require __DIR__ . '/vendor/autoload.php';

    Engine::setMode(Engine::MODE_DEVELOPMENT);
    Engine::setToken('<PUBLIC_KEY>');

    $response = VirtualAccount::instantiate()->verifyDepositTransaction(
        '51328349733' //txnRef - required (string)
    );

    if ($response->hasSucceeded()){
        var_dump($response->getData());
    }
    ```

    ***Response***
    
    ```json
    {
        "code": "00",
        "data": {
            "amount": {
                "amount": 100
            },
            "bankName": "",
            "beneficiaryAccountName": "4427505285",
            "beneficiaryAccountNumber": "4427505285",
            "narration": "Approved by Financial Institution",
            "paymentDate": "2022-08-09T15:56:01.686777",
            "paymentRef": "Z9I8XkNRta1hq2dlmMzlhwQ9F60dLw",
            "sender": "Zainpay Card",
            "senderName": "Zainpay Card",
            "txnDate": "2022-08-09T15:56:01.685982",
            "txnRef": "Q6166237864",
            "txnType": "deposit",
            "zainboxCode": "THbfnDvK5o"
        },
        "description": "successful",
        "status": "200 OK"
    }
    ```

### Deposit Verification V2
- The request can be used to verify a funds deposit or card payment 
    Note: This has different response from the first one because it will enable you to view depositedAmount, txnChargesAmount and amountAfterCharges

    ```php
    use Zainpay\SDK\Engine;
    use Zainpay\SDK\VirtualAccount;

    require __DIR__ . '/vendor/autoload.php';

    Engine::setMode(Engine::MODE_DEVELOPMENT);
    Engine::setToken('<PUBLIC_KEY>');

    $response = VirtualAccount::instantiate()->verifyDepositTransactionV2(
        '<Transaction-Reference>' //txnRef - required (string)
    );

    if ($response->hasSucceeded()){
        var_dump($response->getData());
    }
    ```
    ***Response***

    ```json
    {
        "code": "00",
        "data": {
            "depositedAmount": "100000",
            "txnChargesAmount": "6400",
            "amountAfterCharges": "93600",
            "bankName": "ZainMFB",
            "beneficiaryAccountName": "idris",
            "beneficiaryAccountNumber": "7964524199",
            "narration": "gift",
            "paymentDate": "2021-12-28T11:48:35.044886444",
            "paymentRef": "a1oA0ws127quism",
            "sender": "900989098",
            "senderName": "hassan ",
            "txnDate": "2021-12-28T11:48:35.044777507",
            "txnRef": "730003356",
            "txnType": "deposit",
            "zainboxCode": "xmaldoaYnakaAAVOAE",
            "callBackUrl": "http://gofundme.ng/webhook",
            "emailNotification": "user@user.com",
            "zainboxName": "users",
            
        },
        "description": "successful",
        "status": "200 OK"
    }
    ```



## Bank

### Get Bank List
- This request enables a merchant to get the list of banks supported by Zainpay. 

    ```php
    use Zainpay\SDK\Engine;
    use Zainpay\SDK\Bank;

    require __DIR__ . '/vendor/autoload.php';

    Engine::setMode(Engine::MODE_DEVELOPMENT);
    Engine::setToken('<PUBLIC_KEY>');
    $response = Bank::instantiate()->list();
    if ($response->hasSucceeded()){
        var_dump($response->getData());
    }
    ```

    ***Response***
    ```json
    {
        "code": "00",
        "data": [
            {
            "code": "120001",
            "name": "9PAYMENT SERVICE BANK"
            },
            {
            "code": "090270",
            "name": "AB MICROFINANCE BANK"
            },
            {
            "code": "070010",
            "name": "ABBEY MORTGAGE BANK"
            }
            ],
        "description": "Bank list",
        "status": "Success"
    }   
    ```

### Name Enquiry
- Use the bankCode acquired from the get bank list to validate a bank account number.

    ```php
    use Zainpay\SDK\Engine;
    use Zainpay\SDK\Bank;


    require __DIR__ . '/vendor/autoload.php';

    Engine::setMode(Engine::MODE_DEVELOPMENT);
    Engine::setToken('<PUBLIC_KEY>');

    $response = Bank::instantiate()->accountNameEnquiry(
        "000014",   //bankCode       - required (string)
        "004532112" //accountNumber  - required (string)
    )

    if ($response->hasSucceeded()){
        var_dump($response->getData());
    }
    ```

    ***Response***
    ```json
    {
        "code": "00",
        "data": {
            "accountName": "Nura Aminu Muhammad",
            "accountNumber": "004532112",
            "bankCode": "000014",
            "bankName": "ACCESS BANK"
        },
        "description": "successful",
        "status": "Success"
    }  
    ```

### Fund Transfer
- Fund transfers can be made in the following ways: 
    - Transferring money from one wallet to another
    - Make a bank account transfer from your wallet
    
    Zainpay infers your fund transfer type, so you don't have to specify it. The charges for each form of transfer are different. This charge can be obtained through your commercials.

    **Important Note:**
    - The amount should be converted to kobo decimalization. It is expected that neither float nor double values will be utilized in this case.


    ```php
    use Zainpay\SDK\Engine;
    use Zainpay\SDK\Bank;


    require __DIR__ . '/vendor/autoload.php';

    Engine::setMode(Engine::MODE_DEVELOPMENT);
    Engine::setToken('<PUBLIC_KEY>');

    string $destinationAccountNumber,
        string $destinationBankCode,
        string $amount,
        string $sourceAccountNumber,
        string $sourceBankCode,
        string $zainboxCode,
        string $txnRef,
        string $narration,
        ?string $callbackUrl

    $response = Bank::instantiate()->transfer(
        '004532112',                           //destinationAccountNumber  - required (string)
        '000014',                              //destinationBankCode       - required (string)
        '30050',                               //amount                    - required (string) : 30050 kobos == 300.50 Naira
        '7966884043',                          //sourceAccountNumber       - required (string)
        '000017',                              //sourceBankCode            - required (string)
        'zainboxCode',                         //zainboxCode               - required (string)
        '2Zei390tghmnj',                       //txnRef                    - required (string)
        "Your school fees",                    //narration                 - required (string)      
        'https://example.com/webhook/zainpay', //callbackUrl               - optional (string|null)
    );

    if ($response->hasSucceeded()){
        var_dump($response->getData());
    }
    ```

    ***Response***
    ```json
    {
        "code": "01",
        "description": "successful queued",
        "status": "Queued"
    }  
    ```




For detailed documentation visit the [ZainPay Developer Documentation Page](https://zainpay.ng/developers/). 