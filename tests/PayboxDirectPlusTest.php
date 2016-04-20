<?php

namespace Nexy\PayboxDirect\Tests;

use Nexy\PayboxDirect\Paybox;

/**
 * Paybox class test for Paybox Direct Plus API calls.
 *
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
class PayboxDirectPlusTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Paybox
     */
    private $paybox;

    protected function setUp()
    {
        $this->paybox = new Paybox([
            'paybox_version' => Paybox::VERSION_DIRECT_PLUS,
            'paybox_site' => '1999888',
            'paybox_rang' => '32',
            'paybox_identifiant' => '107904482',
            'paybox_cle' => '1999888I',
        ]);
    }

    /**
     * @expectedException \BadMethodCallException
     */
    public function testBadMethodCall()
    {
        $this->paybox->notExists();
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidArgumentCall()
    {
        $this->paybox->authorize();
    }

    /**
     * @expectedException \Symfony\Component\OptionsResolver\Exception\InvalidArgumentException
     */
    public function testInvalidOptionsCall()
    {
        $this->paybox->authorize([]);
    }

    public function testCallAuthorize()
    {
        $response = $this->paybox->authorize([
            'MONTANT' => 7000,
            'REFERENCE' => uniqid('ref_'),
            'PORTEUR' => '1111222233334444',
            'DATEVAL' => '1216',
            'CVV' => '123',
        ]);

        $this->assertSame(0, $response->getCode(), $response->getComment());
    }

    public function testCallAuthorizeCustomDevise()
    {
        $response = $this->paybox->authorize([
            'MONTANT' => 7000,
            'REFERENCE' => uniqid('ref_'),
            'PORTEUR' => '1111222233334444',
            'DATEVAL' => '1216',
            'CVV' => '123',
            'DEVISE' => 840,
        ]);

        $this->assertSame(0, $response->getCode(), $response->getComment());
    }

    public function testCallAuthorizeGetCountry()
    {
        $response = $this->paybox->authorize([
            'MONTANT' => 7000,
            'REFERENCE' => uniqid('ref_'),
            'PORTEUR' => '1111222233334444',
            'DATEVAL' => '1216',
            'CVV' => '123',
            'PAYS' => '',
        ]);

        $this->assertSame(0, $response->getCode(), $response->getComment());
        $this->assertSame('???', $response->getCountry());
    }

    /**
     * @expectedException \Nexy\PayboxDirect\Exception\PayboxException
     * @expectedExceptionCode 4
     * @expectedExceptionMessage PAYBOX : Numéro de porteur invalide
     */
    public function testCallAuthorizeInvalidPorteur()
    {
        $this->paybox->authorize([
            'MONTANT' => 7000,
            'REFERENCE' => uniqid('ref_'),
            'PORTEUR' => '9999999999999999',
            'DATEVAL' => '1216',
            'CVV' => '123',
        ]);
    }
}
