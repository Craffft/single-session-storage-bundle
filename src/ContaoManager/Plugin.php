<?php

declare(strict_types=1);

namespace Craffft\SingleSessionStorageBundle\ContaoManager;

use Contao\CoreBundle\ContaoCoreBundle;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Craffft\SingleSessionStorageBundle\CraffftSingleSessionStorageBundle;

class Plugin
{
    public function getBundles(ParserInterface $parser)
    {
        return [
            BundleConfig::create(CraffftSingleSessionStorageBundle::class)
                ->setLoadAfter([ContaoCoreBundle::class])
                ->setReplace(['single-session-storage']),
        ];
    }
}
