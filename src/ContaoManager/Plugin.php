<?php

namespace LeiersDesign\ContaoCatalog\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;

use LeiersDesign\ContaoCatalog\ContaoCatalogBundle;

class Plugin implements BundlePluginInterface {

    /**
     * {@inheritdoc}
     */
    public function getBundles(ParserInterface $parser) {
        return [
            BundleConfig::create(ContaoCatalogBundle::class)
				->setLoadAfter([ContaoCoreBundle::class])
				->setReplace(['contao-catalog']),
        ];
    }

}
