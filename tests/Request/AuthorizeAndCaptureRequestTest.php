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
        $request = new AuthorizeAndCaptureRequest($this->generateReference(), 30000, '1111222233334444', '1216');

        $response = $this->paybox->request($request);

        $this->assertSame(0, $response->getCode(), $response->getComment());
    }

    /**
     * @expectedException \Nexy\PayboxDirect\Exception\PayboxException
     * @expectedExceptionCode 4
     * @expectedExceptionMessage PAYBOX : Numéro de porteur invalide
     */
    public function testCallInvalidBearer()
    {
        $request = new AuthorizeAndCaptureRequest($this->generateReference(), 31000, '999999999999', '1216');

        $response = $this->paybox->request($request);

        $this->assertSame(0, $response->getCode(), $response->getComment());
    }

    /**
     * {@inheritdoc}
     */
    protected function createBaseRequest()
    {
        $request = new AuthorizeAndCaptureRequest($this->generateReference(), 30042, '1111222233334444', '1216');

        return $request;
    }
}
