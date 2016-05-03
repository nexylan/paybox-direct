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

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionConfigurationTestCase;
use Nexy\PayboxDirect\Bridge\Symfony\DependencyInjection\Configuration;
use Nexy\PayboxDirect\Bridge\Symfony\DependencyInjection\NexyPayboxDirectExtension;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
class ConfigurationTest extends AbstractExtensionConfigurationTestCase
{
    public function testMinimalConfigurationProcess()
    {
        $expectedConfiguration = [
            'client' => null,
            'options' => [],
            'paybox' => [
                'version' => 'direct_plus',
                'site' => '1999888',
                'rank' => '32',
                'identifier' => '107904482',
                'key' => '1999888I',
            ],
        ];

        $sources = [
            __DIR__.'/../../../fixtures/config/config_minimal.yml',
        ];

        $this->assertProcessedConfigurationEquals($expectedConfiguration, $sources);
    }

    public function testFullConfigurationProcess()
    {
        $expectedConfiguration = [
            'client' => 'fake',
            'options' => [
                'timeout' => 20,
                'production' => true,
            ],
            'paybox' => [
                'version' => 'direct_plus',
                'site' => '1999888',
                'rank' => '32',
                'identifier' => '107904482',
                'key' => '1999888I',
                'default_currency' => 'us_dollar',
            ],
        ];

        $sources = [
            __DIR__.'/../../../fixtures/config/config_full.yml',
        ];

        $this->assertProcessedConfigurationEquals($expectedConfiguration, $sources);
    }

    /**
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testNoneConfigurationProcess()
    {
        $sources = [
            __DIR__.'/../../../fixtures/config/config_none.yml',
        ];

        $this->assertProcessedConfigurationEquals([], $sources);
    }

    /**
     * {@inheritdoc}
     */
    protected function getContainerExtension()
    {
        return new NexyPayboxDirectExtension();
    }

    /**
     * {@inheritdoc}
     */
    protected function getConfiguration()
    {
        return new Configuration();
    }
}
