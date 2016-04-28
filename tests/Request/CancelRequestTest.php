<?php

namespace Nexy\PayboxDirect\Tests\Request;

use Nexy\PayboxDirect\Request\AuthorizeAndCaptureRequest;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
final class CancelRequestTest extends AbstractNumberedReferencedTransactionRequestTest
{
    /**
     * {@inheritdoc}
     */
    protected function getPreviousResponse($amount)
    {
        $request = new AuthorizeAndCaptureRequest(
            $this->generateReference(),
            $amount,
            $this->getCreditCardSerial(),
            $this->getCreditCardValidDate()
        );

        return $this->payboxRequest($request);
    }

    /**
     * {@inheritdoc}
     */
    protected function getExpectedAuthorization()
    {
        return 'XXXXXX';
    }
}
