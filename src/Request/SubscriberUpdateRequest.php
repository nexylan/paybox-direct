<?php

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
