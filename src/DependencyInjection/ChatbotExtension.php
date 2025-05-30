<?php

namespace Chatbot\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class ChatbotExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yaml');

        // Register Doctrine mapping so your entity is recognized
        if ($container->hasExtension('doctrine')) {
            $container->loadFromExtension('doctrine', [
                'orm' => [
                    'mappings' => [
                        'ChatbotBundle' => [
                            'is_bundle' => true,
                            'type' => 'attribute', // or 'annotation' if using annotations
                            'dir' => 'Entity',
                            'prefix' => 'Chatbot\\Entity',
                            'alias' => 'ChatbotBundle',
                        ],
                    ],
                ],
            ]);
        }
    }
    public function prepend(ContainerBuilder $container): void
    {
        $container->prependExtensionConfig('twig', [
            'paths' => [
                __DIR__ . '/../Resources/views' => 'ChatbotBundle',
            ],
        ]);
    }
}
