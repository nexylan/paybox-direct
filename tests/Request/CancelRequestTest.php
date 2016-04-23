<?php

namespace Nexy\PayboxDirect\Tests\Request;

use Nexy\PayboxDirect\Request\AuthorizeAndCaptureRequest;
use Nexy\PayboxDirect\Request\CancelRequest;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
final class CancelRequestTest extends AbstractTransactionRequestTest
{
    public function testCall()
    {
        $request = new AuthorizeAndCaptureRequest(
            $this->generateReference(),
            50000,
            $this->getCreditCardSerial(),
            $this->getCreditCardValidDate()
        );
        $response = $this->paybox->request($request);

        $request = new CancelRequest($this->generateReference(), 50000, $response->getTransactionNumber(), $response->getCallNumber());
        $response = $this->paybox->request($request);

        $this->assertSame(0, $response->getCode(), $response->getComment());
    }

    /**
     * {@inheritdoc}
     */
    protected function createBaseRequest()
    {
        $request = new AuthorizeAndCaptureRequest(
            $this->generateReference(),
            50042,
            $this->getCreditCardSerial(),
            $this->getCreditCardValidDate()
        );
        $response = $this->paybox->request($request);

        $request = new CancelRequest($this->generateReference(), 50042, $response->getTransactionNumber(), $response->getCallNumber());

        return $request;
    }
}
