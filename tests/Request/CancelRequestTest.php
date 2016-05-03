<?php

/*
 * This file is part of the Nexylan packages.
 *
 * (c) Nexylan SAS <contact@nexylan.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
