<?php

namespace Nexy\PayboxDirect\Tests\Request;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
final class CreditRequestTest extends AbstractReferencedBearerTransactionRequestTest
{
    /**
     * {@inheritdoc}
     */
    protected function getInvalidBearerMessage()
    {
        return 'Bin non autorisé pour cette opération';
    }

    /**
     * {@inheritdoc}
     */
    protected function getInvalidBearerCode()
    {
        return 21;
    }

    /**
     * {@inheritdoc}
     */
    protected function getExpectedAuthorization()
    {
        return 'XXXXXX';
    }
}
