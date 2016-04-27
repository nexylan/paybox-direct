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

        $this->payboxRequest($request);
    }

    /**
     * {@inheritdoc}
     */
    protected function createBaseRequest()
    {
        $request = new SubscriberRegisterRequest(
            $this->generateSubscriberReference(),
            $this->generateReference(),
            58000,
            $this->getCreditCardSerial(),
            $this->getCreditCardValidDate()
        );
        $request->setCardVerificationValue('123');

        $response = $this->payboxRequest($request);

        return new SubscriberDeleteRequest($response->getSubscriberRef());
    }

    /**
     * {@inheritdoc}
     */
    protected function getExpectedSha1()
    {
        return false;
    }

    /**
     * {@inheritdoc}
     */
    protected function getExpectedCountry()
    {
        return false;
    }

    /**
     * {@inheritdoc}
     */
    protected function getExpectedCardType()
    {
        return false;
    }

    /**
     * {@inheritdoc}
     */
    protected function getExpectedAuthorization()
    {
        return false;
    }

    /**
     * @return bool
     */
    protected function getExpectedEmptyBearer()
    {
        return true;
    }
}
