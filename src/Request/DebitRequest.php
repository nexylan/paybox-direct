<?php

namespace Nexy\PayboxDirect\Request;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
final class DebitRequest extends AbstractNumberedReferencedTransactionRequest
{
    /**
     * {@inheritdoc}
     */
    public function getRequestType()
    {
        return null !== $this->getSubscriberRef()
            ? RequestInterface::SUBSCRIBER_DEBIT
            : RequestInterface::DEBIT
        ;
    }
}
