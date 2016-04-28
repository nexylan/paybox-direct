<?php

namespace Nexy\PayboxDirect\Tests\HttpClient;

use Nexy\PayboxDirect\HttpClient\AbstractHttpClient;
use Nexy\PayboxDirect\HttpClient\GuzzleHttpClient;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
final class GuzzleHttpClientTest extends AbstractHttpClientTest
{
    /**
     * @return AbstractHttpClient
     */
    protected function getHttpClient()
    {
        return new GuzzleHttpClient();
    }
}
