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
final class SubscriberUpdateRequest extends AbstractBearerTransactionRequest
{
    use AuthorizationTrait;

    /**
     * @param string $subscriberRef
     * @param string $amount
     * @param string $bearer
     * @param string $validityDate
     */
    public function __construct($subscriberRef, $amount, $bearer, $validityDate)
    {
        parent::__construct($amount, $bearer, $validityDate, $subscriberRef);
    }

    /**
     * {@inheritdoc}
     */
    public function getRequestType()
    {
        return RequestInterface::SUBSCRIBER_UPDATE;
    }
}
