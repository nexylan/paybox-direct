<?php

/*
 * This file is part of the Nexylan packages.
 *
 * (c) Nexylan SAS <contact@nexylan.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nexy\PayboxDirect\Tests\Request;

use Nexy\PayboxDirect\Enum\Activity;
use Nexy\PayboxDirect\Request\AbstractRequest;
use Nexy\PayboxDirect\Request\InquiryRequest;
use Nexy\PayboxDirect\Request\RequestInterface;
use Nexy\PayboxDirect\Response\DirectPlusResponse;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
abstract class AbstractRequestTest extends AbstractPayboxSetupTest
{
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

    public function testCallWithOptionalParameters()
    {
        $request = $this->createBaseRequest();
        $request
            ->setActivity(Activity::PHONE_REQUEST)
            ->setDate(new \DateTime('now - 10 days'))
        ;

        if (method_exists($request, 'setAuthorization')) {
            $request->setAuthorization('XXXXXX');
        }

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
     * The goal of this methods is to have a base working object of each request to perform common test on it.
     *
     * @return AbstractRequest
     */
    abstract protected function createBaseRequest();
}
