<?php

namespace Nexy\PayboxDirect\Request;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
final class SubscriberRegisterRequest extends AbstractBearerTransactionRequest
{
    /**
     * @param string $subscriberRef
     * @param string $reference
     * @param string $amount
     * @param string $bearer
     * @param string $validityDate
     */
    public function __construct($subscriberRef, $reference, $amount, $bearer, $validityDate)
    {
        parent::__construct($reference, $amount, $bearer, $validityDate, $subscriberRef);
    }

    /**
     * {@inheritdoc}
     */
    public function getRequestType()
    {
        return RequestInterface::SUBSCRIBER_REGISTER;
    }
}
