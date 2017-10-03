<?php
/**
 * @category    pimcore5-user-tracking
 * @date        22/09/2017
 * @author      Korneliusz Kirsz <kkirsz@divante.pl>
 * @copyright   Copyright (c) 2017 DIVANTE (http://divante.pl)
 */

declare(strict_types=1);

namespace Divante\TrackingBundle;

use Pimcore\Extension\Bundle\Installer\InstallerInterface;
use Pimcore\Extension\Bundle\AbstractPimcoreBundle;

/**
 * Class DivanteTrackingBundle
 * @package Divante\TrackingBundle
 */
class DivanteTrackingBundle extends AbstractPimcoreBundle
{
    /**
     * @return InstallerInterface
     */
    public function getInstaller()
    {
        return $this->container->get(Installer::class);
    }

    /**
     * @return string
     */
    public function getAdminIframePath()
    {
        return 'user-tracking-config';
    }

    /**
     * @return string[]
     */
    public function getJsPaths()
    {
        return [
            '/bundles/divantetracking/js/detailwindow.js',
            '/bundles/divantetracking/js/admin.js',
            '/bundles/divantetracking/js/plugin.js',
        ];
    }
}
