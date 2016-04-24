<?php

namespace Nexy\PayboxDirect\Tests\Request;

use Nexy\PayboxDirect\Request\AuthorizeAndCaptureRequest;
use Nexy\PayboxDirect\Request\SubscriberCancelTransactionRequest;
use Nexy\PayboxDirect\Request\SubscriberRegisterRequest;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
final class SubscriberCancelTransactionRequestTest extends AbstractTransactionRequestTest
{
    /**
     * {@inheritdoc}
     */
    protected function createBaseRequest()
    {
        $request = new SubscriberRegisterRequest(
            $this->generateSubscriberReference(),
            $this->generateReference(),
            55000,
            $this->getCreditCardSerial(),
            $this->getCreditCardValidDate()
        );
        $request->setCardVerificationValue('123');
        $subscriberRegisterResponse = $this->paybox->request($request);

        $request = new AuthorizeAndCaptureRequest(
            $this->generateReference(),
            55000,
            $subscriberRegisterResponse->getBearer(),
            $this->getCreditCardValidDate(),
            $subscriberRegisterResponse->getSubscriberRef()
        );

        $authorizeAndCaptureResponse = $this->paybox->request($request);

        return new SubscriberCancelTransactionRequest(
            $subscriberRegisterResponse->getSubscriberRef(),
            $this->generateReference(),
            55000,
            $subscriberRegisterResponse->getBearer(),
            $this->getCreditCardValidDate(),
            $authorizeAndCaptureResponse->getTransactionNumber(),
            $authorizeAndCaptureResponse->getCallNumber()
        );
    }
}
