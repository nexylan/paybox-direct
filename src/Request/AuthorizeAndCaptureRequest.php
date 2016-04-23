<?php

namespace Nexy\PayboxDirect\Request;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
final class AuthorizeAndCaptureRequest extends AbstractBearerTransactionRequest
{
    /**
     * {@inheritdoc}
     */
    public function getRequestType()
    {
        return RequestInterface::AUTHORIZE_AND_CAPTURE;
    }
}
