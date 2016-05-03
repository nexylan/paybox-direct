<?php

namespace Nexy\PayboxDirect\Tests\Request;

use Nexy\PayboxDirect\Exception\InvalidRequestPropertiesException;
use Nexy\PayboxDirect\Request\AuthorizeRequest;
use Nexy\PayboxDirect\Request\RefundRequest;
use Nexy\PayboxDirect\Request\RequestInterface;

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
    }
}
