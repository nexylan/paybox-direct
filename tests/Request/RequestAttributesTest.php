<?php

namespace Nexy\PayboxDirect\Tests\Request;

use Nexy\PayboxDirect\Exception\InvalidRequestPropertiesException;
use Nexy\PayboxDirect\Request\AuthorizeRequest;
use Nexy\PayboxDirect\Request\RefundRequest;
use Nexy\PayboxDirect\Request\RequestInterface;
use Nexy\PayboxDirect\Request\UpdateAmountRequest;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
class RequestAttributesTest extends AbstractPayboxSetupTest
{
    /**
     * @dataProvider getInvalidRequests
     *
     * @param RequestInterface $request
     * @param int              $expectedErrorsCount
     */
    public function testInvalidRequest(RequestInterface $request, $expectedErrorsCount)
    {
        /* @var InvalidRequestPropertiesException $exception */
        try {
            $this->payboxRequest($request);
        } catch (InvalidRequestPropertiesException $exception) {
            $this->assertCount($expectedErrorsCount, $exception->getErrors());
            return;
        }

        $this->assertTrue(false, 'Request should be invalid.');
    }

    public function getInvalidRequests()
    {
        $request = new AuthorizeRequest('reference', 100, '1111222233334444', '1218');
        $request->setActivity(1337);
        yield 'Wrong activity' => [$request, 1];

        $request = new AuthorizeRequest('reference', 100, '1111222233334444', '1218');
        $request->setActivity(null);
        yield 'Null activity' => [$request, 1];

        $request = new AuthorizeRequest('reference', 100, '1111222233334444', '1218');
        $request
            ->setShowCountry(0)
            ->setShowSha1('test')
            ->setShowCardType(42.1337)
        ;
        yield 'Show * should be a boolean' => [$request, 3];

        $request = new AuthorizeRequest('reference', 100, '1111222233334444', '1218', 42);
        yield 'Subscriber should be a string' => [$request, 1];

        $request = new AuthorizeRequest('reference', 100, '1111222233334444', '1218', str_repeat('0', 251));
        yield 'Subscriber too long' => [$request, 1];

        $request = new AuthorizeRequest('reference', 'fake amount', '1111222233334444', '1218');
        yield 'Amount should be a int' => [$request, 1];

        $request = new AuthorizeRequest('reference', 100, '1111222233334444', '1218');
        $request->setCurrency(999);
        yield 'Wrong currency' => [$request, 1];

        $request = new AuthorizeRequest(42, 100, '1111222233334444', '1218');
        yield 'Reference should be a string' => [$request, 1];

        $request = new AuthorizeRequest(str_repeat('0', 251), 100, '1111222233334444', '1218');
        yield 'Reference too long' => [$request, 1];

        $request = new AuthorizeRequest('reference', 100, 42, 1218);
        $request->setCardVerificationValue(123);
        yield 'Bearer, ValidityDate and CVV should be string' => [$request, 3];

        $request = new AuthorizeRequest('reference', 100, str_repeat('0', 20), '12188');
        $request->setCardVerificationValue('12345');
        yield 'Bearer, ValidityDate and CVV are too long' => [$request, 3];

        $request = new AuthorizeRequest('reference', 100, '1111222233334444', '121');
        $request->setCardVerificationValue('12');
        yield 'ValidityDate and CVV are too short' => [$request, 2];

        $request = new AuthorizeRequest('reference', 100, '1111222233334444', 'abcd');
        $request->setCardVerificationValue('abc');
        yield 'ValidityDate and CVV are invalid' => [$request, 2];

        $request = new UpdateAmountRequest(100, 42, 42);
        $request->setAuthorization(str_repeat('0', 11));
        yield 'Authorization too long' => [$request, 1];

        $request = new UpdateAmountRequest(100, '42', '42');
        yield 'TransactionNumber and CallNumber should be int' => [$request, 2];

        $request = new UpdateAmountRequest(100, 12345678900, 12345678900);
        yield 'TransactionNumber and CallNumber are to long' => [$request, 2];
    }
}
