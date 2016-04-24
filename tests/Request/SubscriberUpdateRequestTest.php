<?php

namespace Nexy\PayboxDirect\Tests\Request;

use Nexy\PayboxDirect\Request\SubscriberRegisterRequest;
use Nexy\PayboxDirect\Request\SubscriberUpdateRequest;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
final class SubscriberUpdateRequestTest extends AbstractTransactionRequestTest
{
    /**
     * {@inheritdoc}
     */
    protected function createBaseRequest()
    {
        $request = new SubscriberRegisterRequest(
            uniqid('sub_up_'),
            $this->generateReference(),
            56000,
            $this->getCreditCardSerial(),
            $this->getCreditCardValidDate()
        );
        $request->setCardVerificationValue('123');

        $response = $this->paybox->request($request);

        return new SubscriberUpdateRequest(
            $response->getSubscriberRef(),
            56042,
            $this->getCreditCardSerial(),
            $this->getCreditCardValidDate()
        );
    }
}
