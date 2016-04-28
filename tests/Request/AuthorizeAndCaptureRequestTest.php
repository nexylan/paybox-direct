<?php

namespace Nexy\PayboxDirect\Tests\Request;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
final class AuthorizeAndCaptureRequestTest extends AbstractReferencedBearerTransactionRequestTest
{
    /**
     * {@inheritdoc}
     */
    protected function getExpectedAuthorization()
    {
        return 'XXXXXX';
    }
}
