<?php

namespace Nexy\PayboxDirect\Request;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
final class AuthorizeAndCaptureRequest extends AbstractReferencedBearerTransactionRequest
{
    use AuthorizationTrait;

    /**
     * {@inheritdoc}
     */
    public function getRequestType()
    {
        return $this->hasSubscriberRef()
            ? RequestInterface::SUBSCRIBER_AUTHORIZE_AND_CAPTURE
            : RequestInterface::AUTHORIZE_AND_CAPTURE
        ;
    }
}
