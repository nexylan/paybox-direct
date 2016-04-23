<?php

namespace Nexy\PayboxDirect\Tests\Request;

use Nexy\PayboxDirect\Request\AuthorizeRequest;
use Nexy\PayboxDirect\Request\DebitRequest;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
class DebitRequestTest extends AbstractRequestTest
{
    public function testCall()
    {
        $request = new AuthorizeRequest($this->generateReference(), 20000, '1111222233334444', '1216');
        $request->setCardVerificationValue('123');
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
        $request = new AuthorizeRequest($this->generateReference(), 20042, '1111222233334444', '1216');
        $request->setCardVerificationValue('123');
        $response = $this->paybox->request($request);

        $request = new DebitRequest($this->generateReference(), 20042, $response->getTransactionNumber(), $response->getCallNumber());

        return $request;
    }
}
