<?php
/**
 * @category    pimcore5-user-tracking
 * @date        26/09/2017
 * @author      Korneliusz Kirsz <kkirsz@divante.pl>
 * @copyright   Copyright (c) 2017 DIVANTE (http://divante.pl)
 */

namespace Divante\TrackingBundle\Helper;

use Pimcore\File;

/**
 * Class ConfigHelper
 * @package Divante\TrackingBundle\Helper
 */
class ConfigHelper
{
    const DEFAULT_USERNAME = '';
    const DEFAULT_PASSWORD = '';
    const DEFAULT_HOST     = '127.0.0.1';
    const DEFAULT_PORT     = '27017';
    const DEFAULT_DATABASE = 'userTrack';

    /**
     * @return array
     */
    public static function get() : array
    {
        $config = [
            'username' => self::DEFAULT_USERNAME,
            'password' => self::DEFAULT_PASSWORD,
            'host'     => self::DEFAULT_HOST,
            'port'     => self::DEFAULT_PORT,
            'database' => self::DEFAULT_DATABASE,
        ];

        $filename = self::getConfigFilename();
        if (file_exists($filename)) {
            $tmp = require $filename;
            if (is_array($tmp)) {
                $config = array_merge($config, $tmp);
            }
        }

        return $config;
    }

    /**
     * @param array $data
     * @param bool $overwrite
     */
    public static function put(array $data, bool $overwrite = true)
    {
        $filename = self::getConfigFilename();
        if (!file_exists($filename) || $overwrite) {
            File::put($filename, to_php_data_file_format($data));
        }
    }

    /**
     * @return string
     */
    private static function getConfigFilename() : string
    {
        return PIMCORE_CONFIGURATION_DIRECTORY . '/divante_tracking-config.php';
    }
}
