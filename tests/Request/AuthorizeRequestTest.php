<?php

namespace Nexy\PayboxDirect\Tests\Request;

use Nexy\PayboxDirect\Request\AuthorizeRequest;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
final class AuthorizeRequestTest extends AbstractRequestTest
{
    public function testCall()
    {
        $request = new AuthorizeRequest(uniqid('ref_'), 7000, '1111222233334444', '1216');
        $request->setCardVerificationValue('123');

        $response = $this->paybox->request($request);

        $this->assertSame(0, $response->getCode(), $response->getComment());
    }

//    public function testCallCustomCurrency()
//    {
//        $response = $this->paybox->authorize([
//            'MONTANT' => 7000,
//            'REFERENCE' => uniqid('ref_'),
//            'PORTEUR' => '1111222233334444',
//            'DATEVAL' => '1216',
//            'CVV' => '123',
//            'DEVISE' => 840,
//        ]);
//
//        $this->assertSame(0, $response->getCode(), $response->getComment());
//    }
//
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
//
//    /**
//     * @expectedException \Nexy\PayboxDirect\Exception\PayboxException
//     * @expectedExceptionCode 4
//     * @expectedExceptionMessage PAYBOX : Numéro de porteur invalide
//     */
//    public function testCallInvalidPorteur()
//    {
//        $this->paybox->authorize([
//            'MONTANT' => 7000,
//            'REFERENCE' => uniqid('ref_'),
//            'PORTEUR' => '9999999999999999',
//            'DATEVAL' => '1216',
//            'CVV' => '123',
//        ]);
//    }
}
