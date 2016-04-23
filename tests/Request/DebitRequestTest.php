<?php

namespace Nexy\PayboxDirect\Tests\Request;

use Nexy\PayboxDirect\Request\AuthorizeRequest;
use Nexy\PayboxDirect\Request\DebitRequest;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
final class DebitRequestTest extends AbstractTransactionRequestTest
{
    public function testCall()
    {
        $request = new AuthorizeRequest(
            $this->generateReference(),
            20000,
            $this->getCreditCardSerial(),
            $this->getCreditCardValidDate()
        );
        $response = $this->paybox->request($request);

        $request = new DebitRequest($this->generateReference(), 20000, $response->getTransactionNumber(), $response->getCallNumber());
        $response = $this->paybox->request($request);

        $this->assertSame(0, $response->getCode(), $response->getComment());
    }

    /**
     * {@inheritdoc}
     */
    protected function createBaseRequest()
    {
        $request = new AuthorizeRequest(
            $this->generateReference(),
            20042,
            $this->getCreditCardSerial(),
            $this->getCreditCardValidDate()
        );
        $response = $this->paybox->request($request);

        $request = new DebitRequest($this->generateReference(), 20042, $response->getTransactionNumber(), $response->getCallNumber());

        return $request;
    }
}
