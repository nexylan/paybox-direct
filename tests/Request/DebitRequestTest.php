<?php

namespace Nexy\PayboxDirect\Tests\Request;

use Nexy\PayboxDirect\Request\AuthorizeRequest;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
final class DebitRequestTest extends AbstractNumberedReferencedTransactionRequestTest
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

        return $this->paybox->request($request);
    }
}
