<?php

namespace Nexy\PayboxDirect\Request;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
final class AuthorizeRequest extends AbstractReferencedBearerTransactionRequest
{
    /**
     * {@inheritdoc}
     */
    public function getRequestType()
    {
        return null !== $this->getSubscriberRef()
            ? RequestInterface::SUBSCRIBER_AUTHORIZE
            : RequestInterface::AUTHORIZE
        ;
    }
}
