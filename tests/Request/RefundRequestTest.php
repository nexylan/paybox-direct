<?php

namespace Nexy\PayboxDirect\Tests\Request;

use Nexy\PayboxDirect\Request\AuthorizeAndCaptureRequest;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
final class RefundRequestTest extends AbstractNumberedReferencedTransactionRequestTest
{
    /**
     * {@inheritdoc}
     */
    final protected function getPreviousResponse($amount)
    {
        $request = new AuthorizeAndCaptureRequest(
            $this->generateReference(),
            $amount,
            $this->getCreditCardSerial(),
            $this->getCreditCardValidDate()
        );

        return $this->paybox->request($request);
    }
}
