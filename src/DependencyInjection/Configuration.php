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
            ->scalarNode('category_role')->defaultValue('ROLE_CHATBOT_ADMIN')->end()
            ->scalarNode('faq_role')->defaultValue('ROLE_CHATBOT_ADMIN')->end()
            ->end();

        return $treeBuilder;
    }
}
