<?php

namespace Nexy\PayboxDirect\Tests\Request;

use Nexy\PayboxDirect\Request\AuthorizeRequest;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
final class InquiryRequestTest extends AbstractNumberedTransactionRequestTest
{
    /**
     * {@inheritdoc}
     */
    final protected function getPreviousResponse($amount)
    {
        $request = new AuthorizeRequest(
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
