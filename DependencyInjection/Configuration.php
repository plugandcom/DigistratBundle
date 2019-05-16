<?php

namespace Plugandcom\Bundle\DigistratBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('plugandcom_digistrat');

        $treeBuilder->getRootNode()
            ->children()
                ->scalarNode('token')
                    ->defaultValue('%env(DIGISTRAT_TOKEN)%')
                    ->cannotBeEmpty()
            ->end()
                ->scalarNode('endpoint')
                    ->defaultValue('%env(DIGISTRAT_ENDPOINT)%')
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
