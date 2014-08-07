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
        $container->setParameter('n1c0_officialtext.model.housepublishing.class', $config['class']['model']['housepublishing']);
        $container->setParameter('n1c0_officialtext.model.tag.class', $config['class']['model']['tag']);
        $container->setParameter('n1c0_officialtext.model.book.class', $config['class']['model']['book']);

        $container->setParameter('n1c0_officialtext.model_manager_name', $config['model_manager_name']);

        $container->setParameter('n1c0_officialtext.form.officialtext.type', $config['form']['officialtext']['type']);
        $container->setParameter('n1c0_officialtext.form.authorsrc.type', $config['form']['authorsrc']['type']);
        $container->setParameter('n1c0_officialtext.form.housepublishing.type', $config['form']['housepublishing']['type']);
        $container->setParameter('n1c0_officialtext.form.tag.type', $config['form']['tag']['type']);
        $container->setParameter('n1c0_officialtext.form.book.type', $config['form']['book']['type']);

        $container->setParameter('n1c0_officialtext.form.officialtext.name', $config['form']['officialtext']['name']);
        $container->setParameter('n1c0_officialtext.form.authorsrc.name', $config['form']['authorsrc']['name']);
        $container->setParameter('n1c0_officialtext.form.housepublishing.name', $config['form']['housepublishing']['name']);
        $container->setParameter('n1c0_officialtext.form.tag.name', $config['form']['tag']['name']);
        $container->setParameter('n1c0_officialtext.form.book.name', $config['form']['book']['name']);

        $container->setAlias('n1c0_officialtext.form_factory.officialtext', $config['service']['form_factory']['officialtext']);
        $container->setAlias('n1c0_officialtext.form_factory.authorsrc', $config['service']['form_factory']['authorsrc']);
        $container->setAlias('n1c0_officialtext.form_factory.housepublishing', $config['service']['form_factory']['housepublishing']);
        $container->setAlias('n1c0_officialtext.form_factory.tag', $config['service']['form_factory']['tag']);
        $container->setAlias('n1c0_officialtext.form_factory.book', $config['service']['form_factory']['book']);

        $container->setAlias('n1c0_officialtext.manager.officialtext', $config['service']['manager']['officialtext']);
        $container->setAlias('n1c0_officialtext.manager.authorsrc', $config['service']['manager']['authorsrc']);
        $container->setAlias('n1c0_officialtext.manager.housepublishing', $config['service']['manager']['housepublishing']);
        $container->setAlias('n1c0_officialtext.manager.tag', $config['service']['manager']['tag']);
        $container->setAlias('n1c0_officialtext.manager.book', $config['service']['manager']['book']);
    }

    protected function loadAcl(ContainerBuilder $container, array $config)
    {
        //$loader = new XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        //$loader->load('acl.xml');

        foreach (array(1 => 'create', 'view', 'edit', 'delete') as $index => $perm) {
            $container->getDefinition('n1c0_officialtext.acl.officialtext.roles')->replaceArgument($index, $config['acl_roles']['officialtext'][$perm]);
            $container->getDefinition('n1c0_officialtext.acl.authorsrc.roles')->replaceArgument($index, $config['acl_roles']['authorsrc'][$perm]);
            $container->getDefinition('n1c0_officialtext.acl.housepublishing.roles')->replaceArgument($index, $config['acl_roles']['housepublishing'][$perm]);
            $container->getDefinition('n1c0_officialtext.acl.tag.roles')->replaceArgument($index, $config['acl_roles']['tag'][$perm]);
            $container->getDefinition('n1c0_officialtext.acl.book.roles')->replaceArgument($index, $config['acl_roles']['book'][$perm]);
        }

        $container->setAlias('n1c0_officialtext.acl.officialtext', $config['service']['acl']['officialtext']);
        $container->setAlias('n1c0_officialtext.acl.authorsrc', $config['service']['acl']['authorsrc']);
        $container->setAlias('n1c0_officialtext.acl.housepublishing', $config['service']['acl']['housepublishing']);
        $container->setAlias('n1c0_officialtext.acl.tag', $config['service']['acl']['tag']);
        $container->setAlias('n1c0_officialtext.acl.book', $config['service']['acl']['book']);
    }
}
