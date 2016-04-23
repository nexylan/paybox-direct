<?php

namespace Nexy\PayboxDirect\Tests\Request;

use Nexy\PayboxDirect\Request\AbstractBearerTransactionRequest;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
abstract class AbstractBearerTransactionRequestTest extends AbstractTransactionRequestTest
{
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
}
