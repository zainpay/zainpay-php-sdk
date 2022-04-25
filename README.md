# Zainpay PHP SDK

## Installation

```
composer require zainpay/sdk
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

How to use them:
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