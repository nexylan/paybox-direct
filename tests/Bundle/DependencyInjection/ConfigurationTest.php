<?php

namespace Nexy\PayboxDirect\Tests\Bundle\DependencyInjection;

use Matthias\SymfonyDependencyInjectionTest\PhpUnit\AbstractExtensionConfigurationTestCase;
use Nexy\PayboxDirect\Bundle\DependencyInjection\Configuration;
use Nexy\PayboxDirect\Bundle\DependencyInjection\NexyPayboxDirectExtension;
use Nexy\PayboxDirect\Paybox;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
class ConfigurationTest extends AbstractExtensionConfigurationTestCase
{
    public function testMinimalConfigurationProcess()
    {
        $expectedConfiguration = [
            'client' => [
                'timeout' => Paybox::DEFAULT_TIMEOUT,
                'production' => Paybox::DEFAULT_PRODUCTION,
            ],
            'paybox' => [
                'version' => 'direct_plus',
                'site' => '1999888',
                'rang' => '32',
                'identifiant' => '107904482',
                'cle' => '1999888I',
                'devise' => 'euro',
            ],
        ];

        $sources = [
            __DIR__.'/../../fixtures/config/config_minimal.yml',
        ];

        $this->assertProcessedConfigurationEquals($expectedConfiguration, $sources);
    }

    public function testFullConfigurationProcess()
    {
        $expectedConfiguration = [
            'client' => [
                'timeout' => 20,
                'production' => true,
            ],
            'paybox' => [
                'version' => 'direct_plus',
                'site' => '1999888',
                'rang' => '32',
                'identifiant' => '107904482',
                'cle' => '1999888I',
                'devise' => 'us_dollar',
            ],
        ];

        $sources = [
            __DIR__.'/../../fixtures/config/config_full.yml',
        ];

        $this->assertProcessedConfigurationEquals($expectedConfiguration, $sources);
    }

    /**
     * @expectedException \Symfony\Component\Config\Definition\Exception\InvalidConfigurationException
     */
    public function testNoneConfigurationProcess()
    {
        $sources = [
            __DIR__.'/../../fixtures/config/config_none.yml',
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