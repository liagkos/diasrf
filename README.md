# Create RI18 compatible payment codes for DIAS
* Written for PHP >= 7
* Based on DCT Creditor specs  v1.2

## Why did I write this
I wanted to create RF for personal use, and since it appeared to be very easy,
I wanted to share it with the rest of the community and use it as a payment gateway for WHMCS.

## Installation

Install the package using Composer:

```
composer require liagkos/diasrf
```

## Usage
* Create payment code

```php
require 'vendor/autoload.php';

use Liagkos\Banks\Dias\RF;

$merchantId        = '1234'; // leading '9' is ignored
$paymentIdentifier = '123456789012345';

$RF = RF::create($merchantId, $paymentIdentifier);
```

* Create payment code with value validation _(not supported by all banks)_

```php
require 'vendor/autoload.php';

use Liagkos\Banks\Dias\RF;

$merchantId        = '1234';
$paymentIdentifier = '123456789012345';
$value             = 15.22;

$RF = RF::create($merchantId, $paymentIdentifier, $value);
```

* Create payment code without value validation as fixed payment order 

```php
require 'vendor/autoload.php';

use Liagkos\Banks\Dias\RF;

$merchantId        = '1234';
$paymentIdentifier = '123456789012345';

$RF = RF::create($merchantId, $paymentIdentifier, 0, 'fixed');
```

* Validate payment code
```php
require 'vendor/autoload.php';

use Liagkos\Banks\Dias\RF;

$paymentCode = 'RF8912349123456789012345';

$isValid = RF::check($merchantId, $paymentIdentifier);
```
## Finally
I'm **NOT** related with DIAS or other banks and *DIAS* word is their respective trademark. I have no responsibilty of any misuse of the program or any damage or loss you may have, including financial damage or loss. Use it are your own risk. 
