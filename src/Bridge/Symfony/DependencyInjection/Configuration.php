<?php

/*
 * This file is part of the Nexylan packages.
 *
 * (c) Nexylan SAS <contact@nexylan.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Nexy\PayboxDirect\Bridge\Symfony\DependencyInjection;

use Nexy\PayboxDirect\Enum\Activity;
use Nexy\PayboxDirect\Enum\Currency;
use Nexy\PayboxDirect\Enum\Version;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * @author Sullivan Senechal <soullivaneuh@gmail.com>
 */
final class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('nexy_paybox_direct');

        $rootNode
            ->children()
                ->scalarNode('client')->defaultNull()->end()
                ->arrayNode('options')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->integerNode('timeout')->end()
                        ->booleanNode('production')->end()
                    ->end()
                ->end()
                ->arrayNode('paybox')
                    ->isRequired()
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('version')
                            ->isRequired()
                            ->cannotBeEmpty()
                            ->validate()
                                ->ifNotInArray(Version::getKeys('strtolower'))
                                ->thenInvalid('Invalid Paybox version')
                            ->end()
                        ->end()
                        ->scalarNode('site')->isRequired()->cannotBeEmpty()->end()
                        ->scalarNode('rank')->isRequired()->cannotBeEmpty()->end()
                        ->scalarNode('identifier')->isRequired()->cannotBeEmpty()->end()
                        ->scalarNode('key')->isRequired()->cannotBeEmpty()->end()
                        ->scalarNode('default_currency')
                            ->validate()
                                ->ifNotInArray(Currency::getKeys('strtolower'))
                                ->thenInvalid('Invalid Paybox version')
                            ->end()
                        ->end()
                        ->scalarNode('default_activity')
                            ->validate()
                                ->ifNotInArray(Activity::getKeys('strtolower'))
                                ->thenInvalid('Invalid Paybox activity')
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
