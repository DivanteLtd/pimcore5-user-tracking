<?php
/**
 * @category    pimcore5-user-tracking
 * @date        25/09/2017
 * @author      Korneliusz Kirsz <kkirsz@divante.pl>
 * @copyright   Copyright (c) 2017 DIVANTE (http://divante.pl)
 */

declare(strict_types=1);

namespace Divante\TrackingBundle\Model;

use Divante\TrackingBundle\Mongo\Db;
use MongoDB\Driver\Cursor;

/**
 * Class UserTrackRepository
 * @package Divante\TrackingBundle\Model
 */
class UserTrackRepository
{
    /**
     * @var \MongoDB\Collection
     */
    private $collection;

    /**
     * UserTrackRepository constructor.
     */
    public function __construct()
    {
        $this->collection = Db::get()->selectCollection('userTrack');
    }

    /**
     * @param UserTrack $userTrack
     */
    public function add(UserTrack $userTrack) : void
    {
        $this->collection->insertOne($userTrack);
    }

    /**     
     * @param array $filter
     * @param array $options
     * @return Cursor
     */
    public function find(array $filter = [], array $options = []) : Cursor
    {
        return $this->collection->find($filter, $options);
    }

    /**     
     * @param array $filter
     * @return int
     */
    public function count(array $filter = []) : int
    {
        return $this->collection->count($filter);
    }
}
