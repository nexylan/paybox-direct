<?php

namespace Nexy\PayboxDirect\Tests\Request;

use Nexy\PayboxDirect\Request\SubscriberRegisterRequest;

/**
 * Same as parent but a with a subscriber call test.
 *
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
abstract class AbstractNumberedReferencedTransactionRequestWithSubscriberTest
    extends AbstractNumberedReferencedTransactionRequestTest
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
        $response = $this->paybox->request($request);

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

        $response = $this->paybox->request($request);

        $this->assertSame(0, $response->getCode(), $response->getComment());
    }
}
