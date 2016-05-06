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

use Nexy\PayboxDirect\Request\SubscriberRegisterRequest;
use Nexy\PayboxDirect\Request\SubscriberUpdateRequest;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
final class SubscriberUpdateRequestTest extends AbstractTransactionRequestTest
{
    /**
     * {@inheritdoc}
     */
    protected function createBaseRequest()
    {
        $request = new SubscriberRegisterRequest(
            $this->generateSubscriberReference(),
            $this->generateReference(),
            57000,
            $this->getCreditCardSerial(),
            $this->getCreditCardValidDate()
        );
        $request->setCardVerificationValue('123');

        $response = $this->payboxRequest($request);

        return new SubscriberUpdateRequest(
            $response->getSubscriberRef(),
            $this->generateReference(),
            57042,
            $this->getCreditCardSerial(),
            $this->getCreditCardValidDate()
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function getExpectedAuthorization()
    {
        return 'XXXXXX';
    }
}
