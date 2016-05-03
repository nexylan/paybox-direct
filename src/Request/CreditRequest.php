<?php

/*
 * This file is part of the Nexylan packages.
 *
 * (c) Nexylan SAS <contact@nexylan.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nexy\PayboxDirect\Request;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
class CreditRequest extends AbstractReferencedBearerTransactionRequest
{
    /**
     * {@inheritdoc}
     */
    public function getRequestType()
    {
        return $this->hasSubscriberRef()
            ? RequestInterface::SUBSCRIBER_CREDIT
            : RequestInterface::CREDIT
        ;
    }
}
