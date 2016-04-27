<?php

namespace Nexy\PayboxDirect\Tests\Request;

use Nexy\PayboxDirect\Enum\Activity;
use Nexy\PayboxDirect\Enum\Version;
use Nexy\PayboxDirect\Paybox;
use Nexy\PayboxDirect\Request\AbstractRequest;

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

    /**
     * Check types and also call getter for each request type to be sures elements are always returned.
     */
    public function testCallResponseAttributes()
    {
        $request = $this->createBaseRequest();
        $response = $this->paybox->request($request);

        $this->assertInternalType('int', $response->getCode());
        $this->assertInternalType('string', $response->getComment());
        $this->assertSame('1999888', $response->getSite());
        $this->assertSame('32', $response->getRank());
        $this->assertInternalType('int', $response->getCallNumber());
        $this->assertInternalType('int', $response->getQuestionNumber());
        $this->assertInternalType('int', $response->getTransactionNumber());
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

    public function testCallShowExtraAttributes()
    {
        $request = $this->createBaseRequest();
        $request
            ->setShowSha1(true)
            ->setShowCountry(true)
            ->setShowCardType(true)
        ;

        $response = $this->paybox->request($request);

        $this->assertSame(0, $response->getCode(), $response->getComment());
        $this->assertSame($this->getExpectedSha1(), $response->getSha1());
        $this->assertSame($this->getExpectedCountry(), $response->getCountry());
        $this->assertSame($this->getExpectedCardType(), $response->getCardType());
    }

    public function testCallNotExtraAttributes()
    {
        // Show Sha1 is false by default
        $request = $this->createBaseRequest();

        $response = $this->paybox->request($request);

        $this->assertSame(0, $response->getCode(), $response->getComment());
        $this->assertNull($response->getSha1());
        $this->assertNull($response->getCountry());
        $this->assertNull($response->getCardType());
    }

    public function testCallAuthorization()
    {
        $request = $this->createBaseRequest();

        $response = $this->paybox->request($request);

        $this->assertSame($this->getExpectedAuthorization(), $response->getAuthorization());
    }

    /**
     * @return string
     */
    protected function getPayboxVersion()
    {
        return Version::DIRECT_PLUS;
    }

    /**
     * @return string|bool
     */
    protected function getExpectedSha1()
    {
        return '678AEDDA00FA890C9056626FFB5699C57BC602B0';
    }

    /**
     * @return string|bool
     */
    protected function getExpectedCountry()
    {
        return false;
    }

    /**
     * @return string|bool
     */
    protected function getExpectedCardType()
    {
        return 'Visa';
    }

    /**
     * @return string|null|false
     */
    protected function getExpectedAuthorization()
    {
        return;
    }

    /**
     * @return string
     */
    protected function getCreditCardSerial()
    {
        return '4012001037141112';
    }

    /**
     * @return string
     */
    protected function getCreditCardValidDate()
    {
        return '12'.(date('y') + 2);
    }

    /**
     * @return string
     */
    final protected function generateReference()
    {
        $requestName = strtolower(str_replace([__NAMESPACE__.'\\', 'RequestTest'], '', get_class($this)));

        return uniqid('npd_'.$requestName.'_');
    }

    /**
     * @return string
     */
    final protected function generateSubscriberReference()
    {
        $requestName = strtolower(str_replace([__NAMESPACE__.'\\', 'RequestTest'], '', get_class($this)));

        return uniqid('sub_'.$requestName.'_');
    }

    /**
     * @return string
     */
    final protected function getRequestClass()
    {
        $className = str_replace([__NAMESPACE__.'\\', 'Test'], '', get_class($this));

        return 'Nexy\\PayboxDirect\\Request\\'.$className;
    }

    /**
     * The goal of this methods is to have a base working object of each request to perform common test on it.
     *
     * @return AbstractRequest
     */
    abstract protected function createBaseRequest();
}
