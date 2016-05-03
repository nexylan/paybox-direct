<?php

namespace Nexy\PayboxDirect\Request;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
final class AuthorizeRequest extends AbstractReferencedBearerTransactionRequest
{
    use AuthorizationTrait;

    /**
     * {@inheritdoc}
     */
    public function getRequestType()
    {
        return $this->hasSubscriberRef()
            ? RequestInterface::SUBSCRIBER_AUTHORIZE
            : RequestInterface::AUTHORIZE
        ;
    }
}
