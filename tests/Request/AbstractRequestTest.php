<?php

namespace Nexy\PayboxDirect\Tests\Request;

use GuzzleHttp\Psr7\Request;
use Nexy\PayboxDirect\Enum\Activity;
use Nexy\PayboxDirect\Enum\Version;
use Nexy\PayboxDirect\Paybox;
use Nexy\PayboxDirect\Request\AbstractRequest;
use Nexy\PayboxDirect\Request\InquiryRequest;
use Nexy\PayboxDirect\Request\RequestInterface;
use Nexy\PayboxDirect\Response\DirectPlusResponse;
use Nexy\PayboxDirect\Response\DirectResponse;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
abstract class AbstractRequestTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Paybox
     */
    private $paybox;

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
        $response = $this->payboxRequest($request);

        $this->assertInternalType('int', $response->getCode());
        $this->assertInternalType('string', $response->getComment());
        $this->assertSame('1999888', $response->getSite());
        $this->assertSame('32', $response->getRank());
        $this->assertInternalType('int', $response->getCallNumber());
        $this->assertInternalType('int', $response->getQuestionNumber());
        $this->assertInternalType('int', $response->getTransactionNumber());
        $this->assertSame($this->getExpectedAuthorization(), $response->getAuthorization());

        // Not called extra attributes
        $this->assertNull($response->getSha1());
        $this->assertNull($response->getCountry());
        $this->assertNull($response->getCardType());

        // Direct plus special attributes
        if ($response instanceof DirectPlusResponse) {
            $this->assertNotEmpty($response->getSubscriberRef());
            if (false === $this->getExpectedEmptyBearer()) {
                $this->assertNotEmpty($response->getBearer());
            } else {
                $this->assertFalse($response->getBearer());
            }
        }
    }

    public function testCallWithCustomActivity()
    {
        $request = $this->createBaseRequest();
        $request
            ->setActivity(Activity::PHONE_REQUEST)
        ;

        $response = $this->payboxRequest($request);

        $this->assertSame(0, $response->getCode(), $response->getComment());
    }

    public function testCallCustomDate()
    {
        $request = $this->createBaseRequest();
        // Have to find a way to test the date result on response.
        $request->setDate(new \DateTime('now - 10 days'));

        $response = $this->payboxRequest($request);

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

        $response = $this->payboxRequest($request);

        $this->assertSame(0, $response->getCode(), $response->getComment());
        $this->assertSame($this->getExpectedSha1(), $response->getSha1());
        $this->assertSame($this->getExpectedCountry(), $response->getCountry());
        $this->assertSame($this->getExpectedCardType(), $response->getCardType());
    }

    public function testInvalidRequestCall()
    {
        $this->expectException(\InvalidArgumentException::class);

        $request = $this->createBaseRequest();
        if ($request instanceof InquiryRequest || $request->getRequestType() >= RequestInterface::SUBSCRIBER_AUTHORIZE) {
            $this->paybox->sendDirectRequest($request);
        } else {
            $this->paybox->sendDirectPlusRequest($request);
        }
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
     * @return bool
     */
    protected function getExpectedEmptyBearer()
    {
        return false;
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
     * @param RequestInterface $request
     *
     * @return DirectResponse|DirectPlusResponse
     */
    final protected function payboxRequest(RequestInterface $request)
    {
        if ($request instanceof InquiryRequest) {
            return $this->paybox->sendInquiryRequest($request);
        }
        if ($request->getRequestType() >= RequestInterface::SUBSCRIBER_AUTHORIZE) {
            return $this->paybox->sendDirectPlusRequest($request);
        }

        return $this->paybox->sendDirectRequest($request);
    }

    /**
     * The goal of this methods is to have a base working object of each request to perform common test on it.
     *
     * @return AbstractRequest
     */
    abstract protected function createBaseRequest();
}
