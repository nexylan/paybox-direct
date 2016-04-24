<?php

namespace Nexy\PayboxDirect\Tests\Request;

use Nexy\PayboxDirect\Exception\PayboxException;
use Nexy\PayboxDirect\Request\SubscriberDeleteRequest;
use Nexy\PayboxDirect\Request\SubscriberRegisterRequest;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
class SubscriberDeleteRequestTest extends AbstractRequestTest
{
    public function testCallNotExistentSubscriber()
    {
        $this->expectException(PayboxException::class);
        $this->expectExceptionCode(17);
        $this->expectExceptionMessage('PAYBOX : Abonné inexistant');

        $request = new SubscriberDeleteRequest('fake');

        $this->paybox->request($request);
    }

    /**
     * {@inheritdoc}
     */
    protected function createBaseRequest()
    {
        $request = new SubscriberRegisterRequest(
            uniqid('sub_up_'),
            $this->generateReference(),
            58000,
            $this->getCreditCardSerial(),
            $this->getCreditCardValidDate()
        );
        $request->setCardVerificationValue('123');

        $response = $this->paybox->request($request);

        return new SubscriberDeleteRequest($response->getSubscriberRef());
    }

    /**
     * {@inheritdoc}
     */
    protected function getExpectedCountry()
    {
        return '';
    }
}
