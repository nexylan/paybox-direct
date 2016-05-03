# PayboxDirect SDK

Paybox Direct and Paybox Direct Plus PHP SDK.

[![Latest Stable Version](https://poser.pugx.org/nexylan/paybox-direct/v/stable)](https://packagist.org/packages/nexylan/paybox-direct)
[![Latest Unstable Version](https://poser.pugx.org/nexylan/paybox-direct/v/unstable)](https://packagist.org/packages/nexylan/paybox-direct)
[![License](https://poser.pugx.org/nexylan/paybox-direct/license)](https://packagist.org/packages/nexylan/paybox-direct)
[![Dependency Status](https://www.versioneye.com/php/nexylan:paybox-direct/badge.svg)](https://www.versioneye.com/php/nexylan:paybox-direct)
[![Reference Status](https://www.versioneye.com/php/nexylan:paybox-direct/reference_badge.svg)](https://www.versioneye.com/php/nexylan:paybox-direct/references)

[![Total Downloads](https://poser.pugx.org/nexylan/paybox-direct/downloads)](https://packagist.org/packages/nexylan/paybox-direct)
[![Monthly Downloads](https://poser.pugx.org/nexylan/paybox-direct/d/monthly)](https://packagist.org/packages/nexylan/paybox-direct)
[![Daily Downloads](https://poser.pugx.org/nexylan/paybox-direct/d/daily)](https://packagist.org/packages/nexylan/paybox-direct)

[![Build Status](https://travis-ci.org/nexylan/paybox-direct.svg?branch=master)](https://travis-ci.org/nexylan/paybox-direct)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/nexylan/paybox-direct/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/nexylan/paybox-direct/?branch=master)
[![Code Climate](https://codeclimate.com/github/nexylan/paybox-direct/badges/gpa.svg)](https://codeclimate.com/github/nexylan/paybox-direct)
[![Coverage Status](https://coveralls.io/repos/nexylan/paybox-direct/badge.svg?branch=master)](https://coveralls.io/r/nexylan/paybox-direct?branch=master)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/ec7d670c-71e3-4c1a-8c12-d91a1c90c2a7/mini.png)](https://insight.sensiolabs.com/projects/ec7d670c-71e3-4c1a-8c12-d91a1c90c2a7)

## Documentation

All the installation and usage instructions are located in this README.
Check it for a specific versions:

* [__0.x__](https://github.com/nexylan/paybox-direct/tree/master) with support for Symfony `^2.7 || ^3.0`

## Prerequisites

This version of the project requires:

* PHP 5.6+
* Symfony 2.7+ for bundle integration

## Installation

First of all, you need to require this library through Composer:

``` bash
composer require nexylan/paybox-direct
```

After this, you can use it as is.

If you are using it on a **Symfony** project,
you should read the following instructions for a better integration.

### As a Symfony bundle

If your project **is not using** [Symfony Full Stack](http://symfony.com/projects/symfonyfs),
you must add the following dependencies:

```bash
composer require symfony/dependency-injection symfony/http-kernel
```

Register the bundle in the kernel of your application:

``` php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Nexy\PayboxDirect\Bridge\Symfony\Bundle\NexyPayboxDirectBundle(),
    );

    // ...

    return $bundles
}
```

Some configuration is required. Here is the default one:

```yaml
nexy_paybox_direct:
    client:               null
    options:
        timeout:              ~
        production:           ~
    paybox:               # Required
        version:              ~ # Required
        site:                 ~ # Required
        rank:                 ~ # Required
        identifier:           ~ # Required
        key:                  ~ # Required
        default_currency:     ~
```

## Usage

### Get the client instance

To communicate with the Paybox Direct (Plus) API, you have to instantiate the `Paybox` class:

```php
use Nexy\PayboxDirect\Enum\Version;
use Nexy\PayboxDirect\Paybox;

$paybox = new Paybox([
    // Optional parameters:
    'timeout' => 30,        // Change the request timeout.
    'production' => true,   // Set to true to use the production API URL.
    // Required parameters:
    'paybox_version' => Version::DIRECT_PLUS,
    'paybox_site' => '1999888',
    'paybox_rank' => '32',
    'paybox_identifier' => '107904482',
    'paybox_key' => '1999888I',
]);
```

If you are using the Symfony bundle bridge, all the parameters are already defined on the configuration side.

All you have to do is to call the paybox service:

```php
/** @var \Nexy\PayboxDirect\Paybox $paybox */
$paybox = $this->container->get('nexy_paybox_direct.sdk');
```

### Make a request

Here is a commented example of how to make a Paybox Direct request with the SDK:

```php
use Nexy\PayboxDirect\Exception\PayboxException;
use Nexy\PayboxDirect\Request\AuthorizeAndCaptureRequest;

$request = new AuthorizeAndCaptureRequest('CMD-42', 1000, '1111222233334444', '1224');
$request->setCardVerificationValue('123');
try {
    /** @var \Nexy\PayboxDirect\Response\DirectResponse $response */
    $response = $paybox->sendDirectRequest($request);
} catch (PayboxException $e) {
    echo $e->getMessage(); // Prints the Paybox error message.
    /** @var \Nexy\PayboxDirect\Response\DirectResponse $response */
    $response = $e->getResponse(); // Returns the response object if you want to manipulate it.
}
// Do stuff with the response!
```

If you want to do the same via the Direct Plus protocol with a subscriber reference:

```php
$request = new AuthorizeAndCaptureRequest('CMD-42', 1000, 'subscriberCardRef', '1224', 'subscriberRef');
try {
    /** @var \Nexy\PayboxDirect\Response\DirectPlusResponse $response */
    $response = $paybox->sendDirectPlusRequest($request);
} catch (PayboxException $e) {
    echo $e->getMessage(); // Prints the Paybox error message.
    /** @var \Nexy\PayboxDirect\Response\DirectPlusResponse $response */
    $response = $e->getResponse(); // Returns the response object if you want to manipulate it.
}
// Do stuff with the response!
```

Note that you have to use `Paybox::sendDirectPlusRequest` method that returns a `DirectPlusResponse` object.

### Requests reference

Here is a table listing all the available requests:

| Request ID | `RequestInterface` | `Paybox` method | `ResponseInterface` |
| ---------- | ------------------ | --------------- | ------------------- |
| 00001 | `AuthorizeRequest` | `sendDirectRequest` | `DirectResponse` |
| 00002 | `DebitRequest` | `sendDirectRequest` | `DirectResponse` |
| 00003 | `AuthorizeAndCaptureRequest` | `sendDirectRequest` | `DirectResponse` |
| 00004 | `CreditRequest` | `sendDirectRequest` | `DirectResponse` |
| 00005 | `CancelRequest` | `sendDirectRequest` | `DirectResponse` |
| 00013 | `UpdateAmountRequest` | `sendDirectRequest` | `DirectResponse` |
| 00014 | `RefundRequest` | `sendDirectRequest` | `DirectResponse` |
| 00017 | `InquiryRequest` | `sendInquiryRequest` | `InquiryResponse` |
| 00051 | `AuthorizeRequest` | `sendDirectPlusRequest` | `DirectPlusResponse` |
| 00052 | `DebitRequest` | `sendDirectPlusRequest` | `DirectPlusResponse` |
| 00053 | `AuthorizeAndCaptureRequest` | `sendDirectPlusRequest` | `DirectPlusResponse` |
| 00054 | `CreditRequest` | `sendDirectPlusRequest` | `DirectPlusResponse` |
| 00055 | `SubscriberCancelTransactionRequest` | `sendDirectPlusRequest` | `DirectPlusResponse` |
| 00056 | `SubscriberRegisterRequest` | `sendDirectPlusRequest` | `DirectPlusResponse` |
| 00057 | `SubscriberUpdateRequest` | `sendDirectPlusRequest` | `DirectPlusResponse` |
| 00058 | `SubscriberDeleteRequest` | `sendDirectPlusRequest` | `DirectPlusResponse` |
