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
    public function getRequestId()
    {
        return RequestInterface::DEBIT;
    }
}
