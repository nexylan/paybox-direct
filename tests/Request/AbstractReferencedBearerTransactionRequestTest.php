<?php

namespace Nexy\PayboxDirect\Tests\Request;

use Nexy\PayboxDirect\Exception\PayboxException;
use Nexy\PayboxDirect\Request\AbstractReferencedBearerTransactionRequest;

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

        $response = $this->paybox->request($request);

        $this->assertSame(0, $response->getCode(), $response->getComment());
    }

    public function testCallInvalidBearer()
    {
        $this->expectException(PayboxException::class);
        $this->expectExceptionCode($this->getInvalidBearerCode());
        $this->expectExceptionMessage('PAYBOX : '.$this->getInvalidBearerMessage());

        $requestClass = $this->getRequestClass();
        $request = new $requestClass($this->generateReference(), 40100, '9999999999999999', '1216');

        $response = $this->paybox->request($request);

        $this->assertSame(0, $response->getCode(), $response->getComment());
    }

    public function testCallWithCVV()
    {
        /** @var AbstractReferencedBearerTransactionRequest $request */
        $request = $this->createBaseRequest();
        $request
            ->setCardVerificationValue('123')
        ;

        $response = $this->paybox->request($request);

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
