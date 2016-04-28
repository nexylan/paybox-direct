<?php

namespace Nexy\PayboxDirect\Tests\Request;

use Nexy\PayboxDirect\Enum\Status;
use Nexy\PayboxDirect\Request\AuthorizeRequest;
use Nexy\PayboxDirect\Response\InquiryResponse;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
final class InquiryRequestTest extends AbstractNumberedTransactionRequestTest
{
    /**
     * {@inheritdoc}
     */
    protected function getPreviousResponse($amount)
    {
        $request = new AuthorizeRequest(
            $this->generateReference(),
            $amount,
            $this->getCreditCardSerial(),
            $this->getCreditCardValidDate()
        );

        return $this->payboxRequest($request);
    }

    public function testInquiryAttributes()
    {
        $request = $this->createBaseRequest();
        /** @var InquiryResponse $response */
        $response = $this->payboxRequest($request);

        $this->assertInstanceOf(InquiryResponse::class, $response);
        $this->assertNotEmpty($response->getStatus());
        $this->assertContains($response->getStatus(), Status::getConstants());
        // No documentation of how to get value for this variable.
        // Need to be updated.
        $this->assertNull($response->getDiscount());
    }

    /**
     * {@inheritdoc}
     */
    protected function getExpectedAuthorization()
    {
        return 'XXXXXX';
    }
}
