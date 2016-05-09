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
        $subscriberRef = $this->generateSubscriberReference();

        $request = new SubscriberRegisterRequest(
            $subscriberRef,
            $this->generateReference(),
            56000,
            $this->getCreditCardSerial(),
            $this->getCreditCardValidDate()
        );
        $request->setCardVerificationValue('123');

        $response = $this->payboxRequest($request);

        $this->assertSame(0, $response->getCode(), $response->getComment());
        $this->assertSame($subscriberRef, $response->getSubscriberRef());
    }

    public function testCallInvalidBearer()
    {
        $this->expectException(PayboxException::class);
        $this->expectExceptionCode(4);
        $this->expectExceptionMessage('PAYBOX : Numéro de porteur invalide');

        $request = new SubscriberRegisterRequest(
            $this->generateSubscriberReference(),
            $this->generateReference(),
            56100,
            '9999999999999999',
            '1216'
        );

        $response = $this->payboxRequest($request);

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
            56042,
            $this->getCreditCardSerial(),
            $this->getCreditCardValidDate()
        );

        return $request;
    }

    /**
     * {@inheritdoc}
     */
    protected function getExpectedSha1()
    {
        return '678AEDDA00FA890C9056626FFB5699C57BC602B0L';
    }

    /**
     * {@inheritdoc}
     */
    protected function getExpectedAuthorization()
    {
        return 'XXXXXX';
    }
}
