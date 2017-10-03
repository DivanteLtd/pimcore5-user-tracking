<?php
/**
 * @category    pimcore5-user-tracking
 * @date        25/09/2017
 * @author      Korneliusz Kirsz <kkirsz@divante.pl>
 * @copyright   Copyright (c) 2017 DIVANTE (http://divante.pl)
 */

declare(strict_types=1);

namespace Divante\TrackingBundle\Mongo;

use Divante\TrackingBundle\Helper\ConfigHelper;

/**
 * Class Db
 * @package Divante\TrackingBundle\Mongo
 */
class Db
{
    /**
     * @var \MongoDB\Database
     */
    private static $db = null;

    /**
     * @return \MongoDB\Database
     */
    public static function get() : \MongoDB\Database
    {
        if (null === self::$db) {
            $config = ConfigHelper::get();
            $uri = self::createURI($config);
            self::$db = (new \MongoDB\Client($uri))->selectDatabase($config['database']);
        }
        return self::$db;
    }

    /**
     * @param array $config
     * @return string
     */
    private static function createURI(array $config) : string
    {
        $uri = 'mongodb://';

        if ('' !== $config['username']) {
            $uri .= sprintf('%s:%s@', $config['username'], $config['password']);
        }

        $uri .= $config['host'];

        if ('' !== $config['port']) {
            $uri .= sprintf(':%s', $config['port']);
        }

        return $uri;
    }
}
