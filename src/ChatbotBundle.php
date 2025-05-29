<?php

namespace Chatbot\ChatbotBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\ExtensionInterface;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\Config\FileLocator;

class ChatbotBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        parent::build($container);
    }

    public function boot(): void
    {
        // No-op or custom logic if needed
    }

    public function getContainerExtension(): ?ExtensionInterface
    {
        return new DependencyInjection\ChatbotExtension();
    }
}
