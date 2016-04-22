<?php

namespace Nexy\PayboxDirect\Tests\Request;

use Nexy\PayboxDirect\Request\AuthorizeRequest;
use Nexy\PayboxDirect\Variable\Activity;
use Nexy\PayboxDirect\Variable\Currency;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
final class AuthorizeRequestTest extends AbstractRequestTest
{
    public function testCall()
    {
        $request = new AuthorizeRequest($this->generateReference(), 10000, '1111222233334444', '1216');
        $request->setCardVerificationValue('123');

        $response = $this->paybox->request($request);

        $this->assertSame(0, $response->getCode(), $response->getComment());
    }

    public function testCallCustomCurrency()
    {
        $request = new AuthorizeRequest($this->generateReference(), 11000, '1111222233334444', '1216');
        $request
            ->setCardVerificationValue('123')
            ->setCurrency(Currency::US_DOLLAR)
        ;

        $response = $this->paybox->request($request);

        $this->assertSame(0, $response->getCode(), $response->getComment());
    }

    public function testCallWithCustomActivity()
    {
        $request = new AuthorizeRequest($this->generateReference(), 12000, '1111222233334444', '1216');
        $request
            ->setCardVerificationValue('123')
            ->setActivity(Activity::PHONE_REQUEST)
        ;

        $response = $this->paybox->request($request);

        $this->assertSame(0, $response->getCode(), $response->getComment());
    }

//    public function testCallGetCountry()
//    {
//        $response = $this->paybox->authorize([
//            'MONTANT' => 7000,
//            'REFERENCE' => uniqid('ref_'),
//            'PORTEUR' => '1111222233334444',
//            'DATEVAL' => '1216',
//            'CVV' => '123',
//            'PAYS' => '',
//        ]);
//
//        $this->assertSame(0, $response->getCode(), $response->getComment());
//        $this->assertSame('???', $response->getCountry());
//    }

    /**
     * @expectedException \Nexy\PayboxDirect\Exception\PayboxException
     * @expectedExceptionCode 4
     * @expectedExceptionMessage PAYBOX : Numéro de porteur invalide
     */
    public function testCallInvalidPorteur()
    {
        $request = new AuthorizeRequest($this->generateReference(), 7000, '999999999999', '1216');
        $request->setCardVerificationValue('123');

        $response = $this->paybox->request($request);

        $this->assertSame(0, $response->getCode(), $response->getComment());
    }
}
