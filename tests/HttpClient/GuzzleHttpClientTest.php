<?php

/*
 * This file is part of the Nexylan packages.
 *
 * (c) Nexylan SAS <contact@nexylan.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
