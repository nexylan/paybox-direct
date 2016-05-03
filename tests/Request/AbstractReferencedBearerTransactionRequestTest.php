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
use Nexy\PayboxDirect\Request\AbstractReferencedBearerTransactionRequest;
use Nexy\PayboxDirect\Request\SubscriberRegisterRequest;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
abstract class AbstractReferencedBearerTransactionRequestTest extends AbstractTransactionRequestTest
{
    public function testCallDefault()
    {
        $requestClass = $this->getRequestClass();
        $request = new $requestClass(
            $this->generateReference(),
            40000,
            $this->getCreditCardSerial(),
            $this->getCreditCardValidDate()
        );

        $response = $this->payboxRequest($request);

        $this->assertSame(0, $response->getCode(), $response->getComment());
    }

    public function testCallInvalidBearer()
    {
        $this->expectException(PayboxException::class);
        $this->expectExceptionCode($this->getInvalidBearerCode());
        $this->expectExceptionMessage('PAYBOX : '.$this->getInvalidBearerMessage());

        $requestClass = $this->getRequestClass();
        $request = new $requestClass($this->generateReference(), 40100, '9999999999999999', '1216');

        $response = $this->payboxRequest($request);

        $this->assertSame(0, $response->getCode(), $response->getComment());
    }

    public function testCallWithSubscriber()
    {
        $request = new SubscriberRegisterRequest(
            $this->generateSubscriberReference(),
            $this->generateReference(),
            40200,
            $this->getCreditCardSerial(),
            $this->getCreditCardValidDate()
        );
        $request->setCardVerificationValue('123');
        $response = $this->payboxRequest($request);

        $requestClass = $this->getRequestClass();
        /** @var AbstractReferencedBearerTransactionRequest $requestClass */
        $request = new $requestClass(
            $this->generateReference(),
            40100,
            $response->getBearer(),
            $this->getCreditCardValidDate(),
            $response->getSubscriberRef()
        );
        $this->assertGreaterThan(50, $request->getRequestType(), 'Should be a subscriber request.');

        $response = $this->payboxRequest($request);

        $this->assertSame(0, $response->getCode(), $response->getComment());
    }

    public function testCallWithCVV()
    {
        /** @var AbstractReferencedBearerTransactionRequest $request */
        $request = $this->createBaseRequest();
        $request
            ->setCardVerificationValue('123')
        ;

        $response = $this->payboxRequest($request);

        $this->assertSame(0, $response->getCode(), $response->getComment());
    }

    /**
     * {@inheritdoc}
     */
    final protected function createBaseRequest()
    {
        $requestClass = $this->getRequestClass();
        $request = new $requestClass(
            $this->generateReference(),
            40042,
            $this->getCreditCardSerial(),
            $this->getCreditCardValidDate()
        );

        return $request;
    }

    /**
     * @return string
     */
    protected function getInvalidBearerMessage()
    {
        return 'Numéro de porteur invalide';
    }

    /**
     * @return int
     */
    protected function getInvalidBearerCode()
    {
        return 4;
    }
}
