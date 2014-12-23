<?php

namespace N1c0\OfficialtextBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.htmlcookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('n1c0_officialtext')
            ->children()

                ->scalarNode('db_driver')->cannotBeOverwritten()->isRequired()->end()
                ->scalarNode('model_manager_name')->defaultNull()->end()

                ->arrayNode('form')->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('officialtext')->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('type')->defaultValue('n1c0_officialtext_officialtext')->end()
                                ->scalarNode('name')->defaultValue('n1c0_officialtext_officialtext')->end()
                            ->end()
                        ->end()
                        ->arrayNode('authorsrc')->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('type')->defaultValue('n1c0_officialtext_authorsrc')->end()
                                ->scalarNode('name')->defaultValue('n1c0_officialtext_authorsrc')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()

                ->arrayNode('class')->isRequired()
                    ->children()
                        ->arrayNode('model')->isRequired()
                            ->children()
                                ->scalarNode('officialtext')->isRequired()->end()
                                ->scalarNode('authorsrc')->isRequired()->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()

                ->arrayNode('acl')->end()

                ->arrayNode('acl_roles')->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('officialtext')->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('create')->cannotBeEmpty()->defaultValue('IS_AUTHENTICATED_ANONYMOUSLY')->end()
                                ->scalarNode('view')->cannotBeEmpty()->defaultValue('IS_AUTHENTICATED_ANONYMOUSLY')->end()
                                ->scalarNode('edit')->cannotBeEmpty()->defaultValue('ROLE_ADMIN')->end()
                                ->scalarNode('delete')->cannotBeEmpty()->defaultValue('ROLE_ADMIN')->end()
                            ->end()
                        ->end()
                        ->arrayNode('authorsrc')->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('create')->cannotBeEmpty()->defaultValue('IS_AUTHENTICATED_ANONYMOUSLY')->end()
                                ->scalarNode('view')->cannotBeEmpty()->defaultValue('IS_AUTHENTICATED_ANONYMOUSLY')->end()
                                ->scalarNode('edit')->cannotBeEmpty()->defaultValue('ROLE_ADMIN')->end()
                                ->scalarNode('delete')->cannotBeEmpty()->defaultValue('ROLE_ADMIN')->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()

                ->arrayNode('service')->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('manager')->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('officialtext')->cannotBeEmpty()->defaultValue('n1c0_officialtext.manager.officialtext.default')->end()
                                ->scalarNode('authorsrc')->cannotBeEmpty()->defaultValue('n1c0_officialtext.manager.authorsrc.default')->end()
                            ->end()
                        ->end()
                        ->arrayNode('acl')->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('officialtext')->cannotBeEmpty()->defaultValue('n1c0_officialtext.acl.officialtext.security')->end()
                                ->scalarNode('authorsrc')->cannotBeEmpty()->defaultValue('n1c0_officialtext.acl.authorsrc.security')->end()
                            ->end()
                        ->end()
                        ->arrayNode('form_factory')->addDefaultsIfNotSet()
                            ->children()
                                ->scalarNode('officialtext')->cannotBeEmpty()->defaultValue('n1c0_officialtext.form_factory.officialtext.default')->end()
                                ->scalarNode('authorsrc')->cannotBeEmpty()->defaultValue('n1c0_officialtext.form_factory.authorsrc.default')->end()

                            ->end()
                        ->end()
                        ->scalarNode('markup')->end()
                    ->end()
                ->end();

        return $treeBuilder;
    }
}
