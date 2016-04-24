<?php

namespace Nexy\PayboxDirect\Request;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
final class SubscriberDeleteRequest extends AbstractRequest
{
    /**
     * @param string $subscriberRef
     */
    public function __construct($subscriberRef)
    {
        parent::__construct($subscriberRef);
    }

    /**
     * {@inheritdoc}
     */
    public function getRequestType()
    {
        return RequestInterface::SUBSCRIBER_DELETE;
    }
}
