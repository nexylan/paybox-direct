<?php

namespace Nexy\PayboxDirect\Request;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
class CreditRequest extends AbstractBearerTransactionRequest
{
    /**
     * {@inheritdoc}
     */
    public function getRequestId()
    {
        return RequestInterface::CREDIT;
    }
}
