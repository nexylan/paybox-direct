<?php

namespace Nexy\PayboxDirect\Request;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
final class AuthorizeRequest extends AbstractBearerTransactionRequest
{
    /**
     * {@inheritdoc}
     */
    public function getRequestType()
    {
        return RequestInterface::AUTHORIZE;
    }
}
