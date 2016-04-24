<?php

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
        return null !== $this->getSubscriberRef()
            ? RequestInterface::SUBSCRIBER_CREDIT
            : RequestInterface::CREDIT
        ;
    }
}
