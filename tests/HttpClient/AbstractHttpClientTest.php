<?php

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
