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

        $response = $this->payboxRequest($request);

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
