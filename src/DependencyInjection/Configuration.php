<?php

namespace Cws\Bundle\CognixCacheBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('cognix_cache');

        $treeBuilder
            ->getRootNode()
            ->children()
                ->scalarNode('uri')->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
