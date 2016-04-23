<?php

namespace Nexy\PayboxDirect\Tests\Request;

use Nexy\PayboxDirect\Exception\PayboxException;
use Nexy\PayboxDirect\Request\AbstractBearerTransactionRequest;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
abstract class AbstractBearerTransactionRequestTest extends AbstractTransactionRequestTest
{
    public function testCallDefault()
    {
        $requestClass = $this->getRequestClass();
        $request = new $requestClass(
            $this->generateReference(),
            42000,
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
        $request = new $requestClass($this->generateReference(), 42100, '9999999999999999', '1216');

        $response = $this->paybox->request($request);

        $this->assertSame(0, $response->getCode(), $response->getComment());
    }

    public function testCallWithCVV()
    {
        /** @var AbstractBearerTransactionRequest $request */
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
    protected function createBaseRequest()
    {
        $requestClass = $this->getRequestClass();
        $request = new $requestClass(
            $this->generateReference(),
            42042,
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

    private function getRequestClass()
    {
        $testClassTab = explode('\\', get_class($this));
        $className = str_replace('Test', '', end($testClassTab));

        return 'Nexy\\PayboxDirect\\Request\\'.$className;
    }
}
