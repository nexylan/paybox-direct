<?php

namespace Nexy\PayboxDirect\Tests\Bundle\DependencyInjection;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;
use Nexy\PayboxDirect\Bundle\DependencyInjection\NexyPayboxDirectExtension;
use Nexy\PayboxDirect\HttpClient\GuzzleHttpClient;
use Nexy\PayboxDirect\Paybox;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
class NexyPayboxDirectExtensionTest extends AbstractExtensionTestCase
{
    public function testLoad()
    {
        $this->load();

        $payboxOptions = [
            'paybox_version' => Paybox::VERSION_DIRECT_PLUS,
            'paybox_site' => '1999888',
            'paybox_rank' => '32',
            'paybox_identifier' => '107904482',
            'paybox_cle' => '1999888I',
        ];

        $this->assertContainerBuilderHasParameter('nexy_paybox_direct.options', $payboxOptions);

        $this->assertContainerBuilderHasService('nexy_paybox_direct.sdk', Paybox::class);

        $this->assertContainerBuilderHasServiceDefinitionWithArgument('nexy_paybox_direct.sdk', 0, '%nexy_paybox_direct.options%');
    }

    public function testLoadWithSomeExtraOptions()
    {
        $this->load([
            'options' => [
                'timeout' => 20,
                'production' => true,
            ],
            'paybox' => [
                'devise' => 'us_dollar',
            ],
        ]);

        $payboxOptions = [
            'timeout' => 20,
            'production' => true,
            'paybox_devise' => Paybox::CURRENCY_US_DOLLAR,
            'paybox_version' => Paybox::VERSION_DIRECT_PLUS,
            'paybox_site' => '1999888',
            'paybox_rank' => '32',
            'paybox_identifier' => '107904482',
            'paybox_cle' => '1999888I',
        ];

        $this->assertContainerBuilderHasParameter('nexy_paybox_direct.options', $payboxOptions);

        $this->assertContainerBuilderHasService('nexy_paybox_direct.sdk', Paybox::class);

        $this->assertContainerBuilderHasServiceDefinitionWithArgument('nexy_paybox_direct.sdk', 0, '%nexy_paybox_direct.options%');
    }

    public function testLoadWithCustomHttpClient()
    {
        $this->load([
            'client' => 'guzzle',
        ]);

        $this->assertAttributeInstanceOf(GuzzleHttpClient::class, 'httpClient', $this->container->get('nexy_paybox_direct.sdk'));
    }

    /**
     * @expectedException \Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException
     */
    public function testLoadWithNotExistentHttpClient()
    {
        $this->load([
            'client' => 'fake',
        ]);
    }

    public function testSdkCall()
    {
        $this->load();

        $response = $this->container->get('nexy_paybox_direct.sdk')->authorize([
            'MONTANT' => 7000,
            'REFERENCE' => uniqid('ref_'),
            'PORTEUR' => '1111222233334444',
            'DATEVAL' => '1216',
            'CVV' => '123',
        ]);

        $this->assertSame(0, $response->getCode(), $response->getComment());
    }

    /**
     * {@inheritdoc}
     */
    protected function getMinimalConfiguration()
    {
        return [
            'paybox' => [
                'version' => 'direct_plus',
                'site' => '1999888',
                'rank' => '32',
                'identifier' => '107904482',
                'cle' => '1999888I',
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function getContainerExtensions()
    {
        return [
            new NexyPayboxDirectExtension(),
        ];
    }
}
