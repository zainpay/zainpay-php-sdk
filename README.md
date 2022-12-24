# Zainpay PHP SDK

## Installation Via Composer

```
composer require zainpay/sdk:dev-main
```

## Installation Via download
Download a release version from the [releases page](https://github.com/zainpay/zainpay-php-sdk). Extract, then:
```
 require 'path/to/src/autoload.php';
```

# Usage

This SDK ships with helper class that will help provide global settings for your SDK.<br/>
Further more, methods are provided to help overwrite the globally set configurations within the instantiated request
object.<br/>
The idea of overriding is brought to you for safe usage of this SDK within **async** environment.

**Example: Global settings**

```php
use Zainpay\SDK\Engine;

require __DIR__ . '/vendor/autoload.php';

Engine::setMode(Engine::MODE_DEVELOPMENT);
Engine::setToken('<YOUR-ZAINPAY-TOKEN>');
```

**Example: Override global settings**

```php
use Zainpay\SDK\Engine;
use Zainpay\SDK\ZainBox;

require __DIR__ . '/vendor/autoload.php';

Engine::setMode(Engine::MODE_DEVELOPMENT);
Engine::setToken('<YOUR-ZAINPAY-TEST-TOKEN>');

ZainBox::instantiate()
    ->withMode(Engine::MODE_PRODUCTION)
    ->withToken('<<YOUR-ZAINPAY-LIVE-TOKEN>');
```

**Response Methods**
* [Response->hasSucceeded()](src/Response.php)
* [Response->hasFailed()](src/Response.php)
* [Response->getStatus()](src/Response.php)
* [Response->getCode()](src/Response.php)
* [Response->getData()](src/Response.php)
* [Response->getDescription()](src/Response.php)
* [Response->getResponse()](src/Response.php)

How to use Responses:
```php
use Zainpay\SDK\Engine;
use Zainpay\SDK\ZainBox;

$response = ZainBox::instantiate()
    ->withMode(Engine::MODE_PRODUCTION)
    ->withToken('<<YOUR-ZAINPAY-LIVE-TOKEN>')
    ->list();

var_dump($response->hasSucceeded());
var_dump($response->hasFailed());
var_dump($response->getData());
```


### ZainBox

Create a zainbox. <br/> 
A zainbox is a virtual bucket that allows a merchant to create unlimited multiple virtual accounts. 

```php
use Zainpay\SDK\Engine;
use Zainpay\SDK\ZainBox;

require __DIR__ . '/vendor/autoload.php';

Engine::setMode(Engine::MODE_DEVELOPMENT);
Engine::setToken('<YOUR-ZAINPAY-TOKEN>');

$response = ZainBox::instantiate()->create(
    'Box Test 1',   // Box Name
    'test@example.com',     // Email Address
    ['foods', 'drinks'],    // Tags
    'https://example.com/webhook'   // Webhook Callback Url
);

if ($response->hasSucceeded()){
    echo "Zainbox Created";
}
```

### List ZainBoxes
Get all your created zainboxes
```php
use Zainpay\SDK\Engine;
use Zainpay\SDK\ZainBox;

require __DIR__ . '/vendor/autoload.php';

Engine::setMode(Engine::MODE_DEVELOPMENT);
Engine::setToken('<YOUR-ZAINPAY-TOKEN>');

$response = ZainBox::instantiate()->list();

if ($response->hasSucceeded()){
    var_dump($response->getData());
}
```


### Transaction List

```php
use Zainpay\SDK\Engine;
use Zainpay\SDK\ZainBox;

require __DIR__ . '/vendor/autoload.php';

Engine::setMode(Engine::MODE_DEVELOPMENT);
Engine::setToken('<YOUR-ZAINPAY-TOKEN>');

$response = ZainBox::instantiate()->transactionList('<ZAINBOX-CODE>');

if ($response->hasSucceeded()){
    var_dump($response->getData());
}
```

## Virtual Account
### Create Virtual Account
Create a virtual account. Map a virtual account to a zainbox. A zainbox can hold multiple virtual accounts.
```php
use Zainpay\SDK\Engine;
use Zainpay\SDK\VirtualAccount;

require __DIR__ . '/vendor/autoload.php';

Engine::setMode(Engine::MODE_DEVELOPMENT);
Engine::setToken('<YOUR-ZAINPAY-TOKEN>');
$response = VirtualAccount::instantiate()->createVirtualAccount(
    '<FirstName>'
    '<SurName>'
    '<Email>'
    '<Dob>'
    '<Gender>'
    '<Address>'
    '<Title>'
    '<State>'
    '<ZainboxCode>'
);

if ($response->hasSucceeded()){
    echo "Virtual Account Created";
}
```
### Get All Virtual Account
Get all virtual accounts linked to a zainbox
```php
use Zainpay\SDK\Engine;
use Zainpay\SDK\VirtualAccount;

require __DIR__ . '/vendor/autoload.php';

Engine::setMode(Engine::MODE_DEVELOPMENT);
Engine::setToken('<YOUR-ZAINPAY-TOKEN>');
$response = \Zainpay\SDK\ZainBox::instantiate()->listVirtualAccounts(
'<ZainBoxCode>'
);
if ($response->hasSucceeded()){
    var_dump($response->getData());
}
```

### Card Initialization
Card payment Initialization. <br/>
To initialize Zainpay Card Payment, Amount should be in Kobo.
The data field of the response returned is a url which you can redirect your users to visit and make the payment.

```php
use Zainpay\SDK\Engine;
use Zainpay\SDK\Card;

require __DIR__ . '/vendor/autoload.php';

Engine::setMode(Engine::MODE_DEVELOPMENT);
Engine::setToken('<YOUR-ZAINPAY-TOKEN>');

$response = Card::instantiate()->initializeCardPayment(
    '<Amount>',
    '<Transaction-Reference>',
    '<Email-Address>',
    '<Mobile-Number>',
    '<Zainbox-Code>',
    '<Callback-Url>',
);

if ($response->hasSucceeded()){
    var_dump($response->getData());
}
```
### Card Payment Verification
```php
use Zainpay\SDK\Engine;
use Zainpay\SDK\Card;

require __DIR__ . '/vendor/autoload.php';

Engine::setMode(Engine::MODE_DEVELOPMENT);
Engine::setToken('<YOUR-ZAINPAY-TOKEN>');

$response = Card::instantiate()->verifyCardPayment(
    '<Transaction-Reference>'
);

if ($response->hasSucceeded()){
    var_dump($response->getData());
}
```

For detailed documentation visit the [ZainPay Developer Documentation Page](https://zainpay.ng/developers/). 