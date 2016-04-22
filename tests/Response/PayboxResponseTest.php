<?php

namespace Nexy\PayboxDirect\Tests\Response;

use Nexy\PayboxDirect\Response\PayboxResponse;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
final class PayboxResponseTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var PayboxResponse
     */
    private $response;

    protected function setUp()
    {
        $this->response = new PayboxResponse([
            'CODEREPONSE' => 1337,
            'COMMENTAIRE' => 'French keywords is bad, and you should feel bad!',
        ]);
    }

    public function testValidGetter()
    {
        $this->assertSame(1337, $this->response->getCode());
        $this->assertSame('French keywords is bad, and you should feel bad!', $this->response->getComment());
    }

    public function testNotExistsProperty()
    {
        $this->assertNull($this->response->getDiscount());
    }

    /**
     * @expectedException \BadMethodCallException
     * @expectedExceptionMessage Undefined method getFake
     */
    public function testNotExistsGetter()
    {
        $this->response->getFake();
    }
}