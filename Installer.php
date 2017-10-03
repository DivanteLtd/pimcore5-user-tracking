<?php
/**
 * @category    pimcore5-user-tracking
 * @date        25/09/2017
 * @author      Korneliusz Kirsz <kkirsz@divante.pl>
 * @copyright   Copyright (c) 2017 DIVANTE (http://divante.pl)
 */

declare(strict_types=1);

namespace Divante\TrackingBundle;

use Divante\TrackingBundle\Mongo\Db;
use Pimcore\Extension\Bundle\Installer\Exception\InstallationException;
use Pimcore\Extension\Bundle\Installer\AbstractInstaller;
use Pimcore\Tool\Admin;

/**
 * Class Installer
 * @package Divante\TrackingBundle
 */
class Installer extends AbstractInstaller
{
    /**
     * @return bool
     */
    public function needsReloadAfterInstall()
    {
        return true;
    }
}
