<?php

namespace Nexy\PayboxDirect\Bundle\DependencyInjection;

use Nexy\PayboxDirect\Paybox;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
final class NexyPayboxDirectExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $this->processOptions($config, $container);

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('sdk.xml');
        $loader->load('http_clients.xml');

        $this->processClient($config, $container);
    }

    /**
     * @param array            $config
     * @param ContainerBuilder $container
     */
    private function processOptions(array $config, ContainerBuilder $container)
    {
        // Start with client option
        $options = $config['options'];

        // Paybox version and currency special hack: Get the number.
        $options['paybox_version'] = Paybox::VERSIONS[$config['paybox']['version']];
        unset($config['paybox']['version']);
        if (array_key_exists('currency', $config['paybox'])) {
            $options['paybox_currency'] = Paybox::CURRENCIES[$config['paybox']['currency']];
            unset($config['paybox']['currency']);
        }

        // Convert paybox option format
        foreach ($config['paybox'] as $key => $value) {
            $options['paybox_'.$key] = $value;
        }

        $container->setParameter('nexy_paybox_direct.options', $options);
    }

    /**
     * @param array            $config
     * @param ContainerBuilder $container
     */
    private function processClient(array $config, ContainerBuilder $container)
    {
        if (null === $config['client']) {
            return;
        }

        $container->findDefinition('nexy_paybox_direct.sdk')->addArgument(
            $container->findDefinition('nexy_paybox_direct.http_client.'.$config['client'])
        );
    }
}
