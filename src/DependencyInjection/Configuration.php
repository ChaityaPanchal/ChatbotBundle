<?php
namespace Chatbot\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('chatbot');

        $treeBuilder->getRootNode()
            ->children()
            ->scalarNode('role')->defaultValue('ROLE_CHATBOT_ADMIN')->end()
            ->end();

        return $treeBuilder;
    }
}
