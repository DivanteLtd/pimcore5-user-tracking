<?php
/**
 * @category    pimcore5-user-tracking
 * @date        25/09/2017
 * @author      Korneliusz Kirsz <kkirsz@divante.pl>
 * @copyright   Copyright (c) 2017 DIVANTE (http://divante.pl)
 */

declare(strict_types=1);

namespace Divante\TrackingBundle\Model;

use MongoDB\BSON\ObjectID;
use MongoDB\BSON\Persistable;
use MongoDB\BSON\UTCDateTime;

/**
 * Class UserTrack
 * @package Divante\TrackingBundle\Model
 */
class UserTrack implements Persistable
{
    /**
     * @var ObjectID
     */
    private $id;

    /**
     * @var UTCDateTime
     */
    private $createdAt;

    /**
     * @var int
     */
    private $userId;

    /**
     * @var string
     */
    private $controller;

    /**
     * @var string
     */
    private $route;

    /**
     * @var string
     */
    private $routeParams;

    /**
     * @var string
     */
    private $params;

    /**
     * UserTrack constructor.
     * @param int $userId
     * @param string $controller
     * @param string $route
     * @param string $routeParams
     * @param string $params
     */
    public function __construct(int $userId, string $controller, string $route, string $routeParams, string $params)
    {
        $this->setId(new ObjectID());
        $this->setCreatedAt(new UTCDateTime());
        $this->setUserId($userId);
        $this->setController($controller);
        $this->setRoute($route);
        $this->setRouteParams($routeParams);
        $this->setParams($params);
    }

    /**
     * @return ObjectID
     */
    public function id() : ObjectId
    {
        return $this->id;
    }

    /**
     * @param ObjectID $id
     */
    private function setId(ObjectId $id) : void
    {
        $this->id = $id;
    }

    /**
     * @return UTCDateTime
     */
    public function createdAt() : UTCDateTime
    {
        return $this->createdAt;
    }

    /**
     * @param UTCDateTime $createdAt
     */
    private function setCreatedAt(UTCDateTime $createdAt) : void
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return int
     */
    public function userId() : int
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     */
    private function setUserId(int $userId) : void
    {
        $this->userId = $userId;
    }

    /**
     * @return string
     */
    public function controller() : string
    {
        return $this->controller;
    }

    /**
     * @param string $controller
     */
    private function setController(string $controller) : void
    {
        $this->controller = $controller;
    }

    /**
     * @return string
     */
    public function route() : string
    {
        return $this->route;
    }

    /**
     * @param string $route
     */
    private function setRoute(string $route) : void
    {
        $this->route = $route;
    }

    /**
     * @return string
     */
    public function routeParams() : string
    {
        return $this->routeParams;
    }

    /**
     * @param string $routeParams
     */
    private function setRouteParams(string $routeParams) : void
    {
        $this->routeParams = $routeParams;
    }

    /**
     * @return string
     */
    public function params() : string
    {
        return $this->params;
    }

    /**
     * @param string $params
     */
    private function setParams(string $params) : void
    {
        $this->params = $params;
    }

    /**
     * @return array
     */
    public function bsonSerialize()
    {
        return [
            '_id'         => $this->id(),
            'createdAt'   => $this->createdAt(),
            'userId'      => $this->userId(),
            'controller'  => $this->controller(),
            'route'       => $this->route(),
            'routeParams' => $this->routeParams(),
            'params'      => $this->params(),
        ];
    }

    /**
     * @param array $data
     */
    public function bsonUnserialize(array $data)
    {
        $this->setId($data['_id']);
        $this->setCreatedAt($data['createdAt']);
        $this->setUserId($data['userId']);
        $this->setController($data['controller']);
        $this->setRoute($data['route']);
        $this->setRouteParams($data['routeParams']);
        $this->setParams($data['params']);
    }
}
