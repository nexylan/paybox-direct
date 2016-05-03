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

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
abstract class AbstractHttpClientTest extends \PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        $this->getHttpClient()->init();
    }

    final public function testInvalidResponseClass()
    {
        $this->expectException(\InvalidArgumentException::class);

        $this->getHttpClient()->call(1, [], \StdClass::class);
    }

    /**
     * @return AbstractHttpClient
     */
    abstract protected function getHttpClient();
}
