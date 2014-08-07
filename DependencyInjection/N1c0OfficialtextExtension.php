<?php

/**
 * This file is chapter of the N1c0OfficialtextBundle package.
 *
 * (c) 
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace N1c0\OfficialtextBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Alias;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class N1c0OfficialtextExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        if (array_key_exists('acl', $config)) {
            $this->loadAcl($container, $config);
        }

        $container->setParameter('n1c0_officialtext.model.officialtext.class', $config['class']['model']['officialtext']);
        $container->setParameter('n1c0_officialtext.model.authorsrc.class', $config['class']['model']['authorsrc']);


        $container->setParameter('n1c0_officialtext.model_manager_name', $config['model_manager_name']);

        $container->setParameter('n1c0_officialtext.form.officialtext.type', $config['form']['officialtext']['type']);
        $container->setParameter('n1c0_officialtext.form.authorsrc.type', $config['form']['authorsrc']['type']);


        $container->setParameter('n1c0_officialtext.form.officialtext.name', $config['form']['officialtext']['name']);
        $container->setParameter('n1c0_officialtext.form.authorsrc.name', $config['form']['authorsrc']['name']);


        $container->setAlias('n1c0_officialtext.form_factory.officialtext', $config['service']['form_factory']['officialtext']);
        $container->setAlias('n1c0_officialtext.form_factory.authorsrc', $config['service']['form_factory']['authorsrc']);
      
        $container->setAlias('n1c0_officialtext.manager.officialtext', $config['service']['manager']['officialtext']);
        $container->setAlias('n1c0_officialtext.manager.authorsrc', $config['service']['manager']['authorsrc']);

    }

    protected function loadAcl(ContainerBuilder $container, array $config)
    {
        //$loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        //$loader->load('acl.xml');

        foreach (array(1 => 'create', 'view', 'edit', 'delete') as $index => $perm) {
            $container->getDefinition('n1c0_officialtext.acl.officialtext.roles')->replaceArgument($index, $config['acl_roles']['officialtext'][$perm]);
            $container->getDefinition('n1c0_officialtext.acl.authorsrc.roles')->replaceArgument($index, $config['acl_roles']['authorsrc'][$perm]);

        }

        $container->setAlias('n1c0_officialtext.acl.officialtext', $config['service']['acl']['officialtext']);
        $container->setAlias('n1c0_officialtext.acl.authorsrc', $config['service']['acl']['authorsrc']);

    }
}
