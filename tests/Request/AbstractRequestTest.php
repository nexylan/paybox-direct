<?php

namespace Nexy\PayboxDirect\Tests\Request;

use Nexy\PayboxDirect\Paybox;
use Nexy\PayboxDirect\Request\AbstractRequest;
use Nexy\PayboxDirect\Variable\Activity;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
abstract class AbstractRequestTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Paybox
     */
    protected $paybox;

    protected function setUp()
    {
        $this->paybox = new Paybox([
            'paybox_version' => $this->getPayboxVersion(),
            'paybox_site' => '1999888',
            'paybox_rank' => '32',
            'paybox_identifier' => '107904482',
            'paybox_key' => '1999888I',
        ]);
    }

    public function testCallWithCustomActivity()
    {
        $request = $this->createBaseRequest();
        $request
            ->setActivity(Activity::PHONE_REQUEST)
        ;

        $response = $this->paybox->request($request);

        $this->assertSame(0, $response->getCode(), $response->getComment());
    }

    public function testCallCustomDate()
    {
        $request = $this->createBaseRequest();
        // Have to find a way to test the date result on response.
        $request->setDate(new \DateTime('now - 10 days'));

        $response = $this->paybox->request($request);

        $this->assertSame(0, $response->getCode(), $response->getComment());
    }

    public function testCallShowCountry()
    {
        $request = $this->createBaseRequest();
        $request->setShowCountry(true);

        $response = $this->paybox->request($request);

        $this->assertSame(0, $response->getCode(), $response->getComment());
        $this->assertSame($this->getExpectedCountry(), $response->getCountry());
    }

    public function testCallNotShowCountry()
    {
        // Show country is false by default
        $request = $this->createBaseRequest();

        $response = $this->paybox->request($request);

        $this->assertSame(0, $response->getCode(), $response->getComment());
        $this->assertNull($response->getCountry());
    }

    /**
     * @return string
     */
    protected function getPayboxVersion()
    {
        return Paybox::VERSION_DIRECT_PLUS;
    }

    /**
     * @return string
     */
    protected function getExpectedCountry()
    {
        return '???';
    }

    /**
     * @return string
     */
    final protected function generateReference()
    {
        $requestClassTab = explode('\\', get_class($this));
        $requestName = strtolower(str_replace('RequestTest', '', end($requestClassTab)));

        return uniqid('npd_'.$requestName.'_');
    }

    /**
     * @return string
     */
    final protected function getRequestClass()
    {
        $testClassTab = explode('\\', get_class($this));
        $className = str_replace('Test', '', end($testClassTab));

        return 'Nexy\\PayboxDirect\\Request\\'.$className;
    }

    /**
     * The goal of this methods is to have a base working object of each request to perform common test on it.
     *
     * @return AbstractRequest
     */
    abstract protected function createBaseRequest();
}
