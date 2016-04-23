<?php


namespace Nexy\PayboxDirect\Request;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
final class UpdateAmountRequest extends AbstractNumberedReferencedTransactionRequest
{
    /**
     * {@inheritdoc}
     */
    public function getRequestType()
    {
        return RequestInterface::UPDATE_AMOUNT;
    }
}
