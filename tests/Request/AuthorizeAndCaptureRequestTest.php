<?php

namespace Nexy\PayboxDirect\Tests\Request;

use Nexy\PayboxDirect\Request\AuthorizeAndCaptureRequest;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
final class AuthorizeAndCaptureRequestTest extends AbstractBearerTransactionRequestTest
{
    public function testCall()
    {
        $request = new AuthorizeAndCaptureRequest($this->generateReference(), 10000, '1111222233334444', '1216');

        $response = $this->paybox->request($request);

        $this->assertSame(0, $response->getCode(), $response->getComment());
    }

    /**
     * @expectedException \Nexy\PayboxDirect\Exception\PayboxException
     * @expectedExceptionCode 4
     * @expectedExceptionMessage PAYBOX : Numéro de porteur invalide
     */
    public function testCallInvalidPorteur()
    {
        $request = new AuthorizeAndCaptureRequest($this->generateReference(), 11000, '999999999999', '1216');

        $response = $this->paybox->request($request);

        $this->assertSame(0, $response->getCode(), $response->getComment());
    }

    /**
     * {@inheritdoc}
     */
    protected function createBaseRequest()
    {
        $request = new AuthorizeAndCaptureRequest($this->generateReference(), 10042, '1111222233334444', '1216');

        return $request;
    }
}
