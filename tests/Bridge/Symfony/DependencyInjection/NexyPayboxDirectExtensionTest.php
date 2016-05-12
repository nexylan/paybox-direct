<?php

/*
 * This file is part of the Nexylan packages.
 *
 * (c) Nexylan SAS <contact@nexylan.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nexy\PayboxDirect\Tests\Symfony\Bridge\DependencyInjection;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionTestCase;
use Nexy\PayboxDirect\Bridge\Symfony\DependencyInjection\NexyPayboxDirectExtension;
use Nexy\PayboxDirect\Enum\Currency;
use Nexy\PayboxDirect\Enum\Version;
use Nexy\PayboxDirect\HttpClient\GuzzleHttpClient;
use Nexy\PayboxDirect\Paybox;
use Nexy\PayboxDirect\Request\AuthorizeRequest;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
class NexyPayboxDirectExtensionTest extends AbstractExtensionTestCase
{
    public function testLoad()
    {
        $this->load();

        $payboxOptions = [
            'paybox_version' => Version::DIRECT_PLUS,
            'paybox_site' => '1999888',
            'paybox_rank' => '32',
            'paybox_identifier' => '107904482',
            'paybox_key' => '1999888I',
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
                'default_currency' => 'us_dollar',
            ],
        ]);

        $payboxOptions = [
            'timeout' => 20,
            'production' => true,
            'paybox_default_currency' => Currency::US_DOLLAR,
            'paybox_version' => Version::DIRECT_PLUS,
            'paybox_site' => '1999888',
            'paybox_rank' => '32',
            'paybox_identifier' => '107904482',
            'paybox_key' => '1999888I',
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
        $this->load([
            'paybox' => [
                'default_activity' => 'recurring_payment',
            ],
        ]);

        $request = new AuthorizeRequest(uniqid('npd_extension_'), 1337, '1111222233334444', '1216');

        $response = $this->container->get('nexy_paybox_direct.sdk')->sendDirectRequest($request);

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
                'site' => 1999888,
                'rank' => 32,
                'identifier' => 107904482,
                'key' => '1999888I',
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
