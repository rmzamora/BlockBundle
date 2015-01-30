<?php

/*
 * This file is part of the RzBlockBundle package.
 *
 * (c) mell m. zamora <mell@rzproject.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Rz\BlockBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class RzBlockExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('form_type.xml');
        $loader->load('block.xml');
        $loader->load('core.xml');
        $loader->load('template_provider.xml');
        $this->registerSearchSettings($config, $container);
    }

    /**
     * Registers ckeditor widget.
     *
     */
    protected function registerSearchSettings(array $config, ContainerBuilder $container)
    {
        if (!empty($config['block_template_configs'])) {
            $definition = $container->getDefinition('rz_block.config_block_template_provider_manager');
            foreach ($config['block_template_configs'] as $name => $configuration) {
                    $definition->addMethodCall('setConfig', array($name, $configuration));
            }
        }
    }
}
