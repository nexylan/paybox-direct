<?php

namespace Nexy\PayboxDirect\Tests\Request;

use Nexy\PayboxDirect\Exception\PayboxException;
use Nexy\PayboxDirect\Request\AbstractRequest;
use Nexy\PayboxDirect\Request\SubscriberRegisterRequest;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
class SubscriberRegisterRequestTest extends AbstractTransactionRequestTest
{
    public function testCallDefault()
    {
        $request = new SubscriberRegisterRequest(
            $this->generateSubscriberReference(),
            $this->generateReference(),
            60000,
            $this->getCreditCardSerial(),
            $this->getCreditCardValidDate()
        );
        $request->setCardVerificationValue('123');

        $response = $this->paybox->request($request);

        $this->assertSame(0, $response->getCode(), $response->getComment());
    }

    public function testCallInvalidBearer()
    {
        $this->expectException(PayboxException::class);
        $this->expectExceptionCode(4);
        $this->expectExceptionMessage('PAYBOX : Numéro de porteur invalide');

        $request = new SubscriberRegisterRequest(
            $this->generateSubscriberReference(),
            $this->generateReference(),
            60100,
            '9999999999999999',
            '1216'
        );

        $response = $this->paybox->request($request);

        $this->assertSame(0, $response->getCode(), $response->getComment());
    }

    /**
     * The goal of this methods is to have a base working object of each request to perform common test on it.
     *
     * @return AbstractRequest
     */
    protected function createBaseRequest()
    {
        $request = new SubscriberRegisterRequest(
            $this->generateSubscriberReference(),
            $this->generateReference(),
            60042,
            $this->getCreditCardSerial(),
            $this->getCreditCardValidDate()
        );

        return $request;
    }

    /**
     * @return string
     */
    final protected function generateSubscriberReference()
    {
        $requestClassTab = explode('\\', get_class($this));
        $requestName = strtolower(str_replace('RequestTest', '', end($requestClassTab)));

        return uniqid('sub_'.$requestName.'_');
    }
}
