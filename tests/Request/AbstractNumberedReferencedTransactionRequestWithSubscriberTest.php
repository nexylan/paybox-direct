<?php

/*
 * This file is part of the Nexylan packages.
 *
 * (c) Nexylan SAS <contact@nexylan.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nexy\PayboxDirect\Tests\Request;

use Nexy\PayboxDirect\Request\AbstractNumberedTransactionRequest;
use Nexy\PayboxDirect\Request\SubscriberRegisterRequest;

/**
 * Same as parent but a with a subscriber call test.
 *
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
abstract class AbstractNumberedReferencedTransactionRequestWithSubscriberTest extends AbstractNumberedReferencedTransactionRequestTest
{
    public function testCallWithSubscriber()
    {
        $request = new SubscriberRegisterRequest(
            $this->generateSubscriberReference(),
            $this->generateReference(),
            42100,
            $this->getCreditCardSerial(),
            $this->getCreditCardValidDate()
        );
        $request->setCardVerificationValue('123');
        $response = $this->payboxRequest($request);

        $requestClass = $this->getRequestClass();
        /** @var AbstractNumberedTransactionRequest $requestClass */
        $request = new $requestClass(
            $this->generateReference(),
            42100,
            $response->getTransactionNumber(),
            $response->getCallNumber(),
            $response->getSubscriberRef()
        );
        $this->assertGreaterThan(50, $request->getRequestType(), 'Should be a subscriber request.');

        $response = $this->payboxRequest($request);

        $this->assertSame(0, $response->getCode(), $response->getComment());
    }
}
