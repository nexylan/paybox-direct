<?php

namespace Nexy\PayboxDirect\Tests\Request;

use Nexy\PayboxDirect\Enum\Currency;
use Nexy\PayboxDirect\Request\AbstractTransactionRequest;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
abstract class AbstractTransactionRequestTest extends AbstractRequestTest
{
    public function testCallCustomCurrency()
    {
        /** @var AbstractTransactionRequest $request */
        $request = $this->createBaseRequest();
        $request
            ->setCurrency(Currency::US_DOLLAR)
        ;

        $response = $this->paybox->request($request);

        $this->assertSame(0, $response->getCode(), $response->getComment());
    }

    /**
     * {@inheritdoc}
     */
    protected function getExpectedCountry()
    {
        return 'USA';
    }
}
