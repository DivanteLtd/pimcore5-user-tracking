<?php
/**
 * @category    pimcore5-user-tracking
 * @date        25/09/2017
 * @author      Korneliusz Kirsz <kkirsz@divante.pl>
 * @copyright   Copyright (c) 2017 DIVANTE (http://divante.pl)
 */

declare(strict_types=1);

namespace Divante\TrackingBundle\Controller;

use Divante\TrackingBundle\Model\UserTrack;
use Divante\TrackingBundle\Model\UserTrackRepository;
use MongoDB\BSON\Regex;
use MongoDB\BSON\UTCDateTime;
use Pimcore\Admin\Helper\QueryParams;
use Pimcore\Bundle\AdminBundle\Controller\AdminController;
use Pimcore\Bundle\AdminBundle\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TrackingController
 * @package Divante\TrackingBundle\Controller
 * @Route("/user-tracking")
 */
class TrackingController extends AdminController
{
    /**
     * @var UserTrackRepository
     */
    private $repository;

    /**
     * TrackingController constructor.
     */
    public function __construct()
    {
        $this->repository = new UserTrackRepository();
    }

    /**
     * @return JsonResponse
     * @Route("/find")
     */
    public function findAction(Request $request) : JsonResponse
    {
        $items   = [];        
        $filter  = $this->parseFilter($request);
        $options = $this->parseOptions($request);
        
        /* @var $item UserTrack */
        foreach ($this->repository->find($filter, $options) as $item) {
            $items[] = [
                'id'          => (string) $item->id(),
                'createdAt'   => date('Y-m-d H:i:s', (int) $item->createdAt()->toDateTime()->format('U')),
                'userId'      => $item->userId(),
                'controller'  => $item->controller(),
                'route'       => $item->route(),
                'routeParams' => $item->routeParams(),
                'params'      => $item->params(),
            ];
        }

        return $this->json([
            'p_totalCount' => $this->repository->count($filter),
            'p_results'    => $items
        ]);
    }
    
    /**     
     * @param Request $request
     * @return array
     */
    private function parseFilter(Request $request) : array
    {
        $filter    = [];
        $createdAt = [];

        $fromDate = $request->get('fromDate', '');
        if ('' !== $fromDate) {
            $fromTime = $request->get('fromTime', '');
            $createdAt['$gte'] = $this->parseDateTime($fromDate, $fromTime);
        }

        $toDate = $request->get('toDate', '');
        if ('' !== $toDate) {
            $toTime = $request->get('toTime', '');
            $createdAt['$lte'] = $this->parseDateTime($toDate, $toTime);
        }
        
        if (!empty($createdAt)) {
            $filter['createdAt'] = $createdAt;
        }

        $userId = $request->get('userId', '');
        if ('' !== $userId) {
            $filter['userId'] = (int) $userId;
        }

        $controller = $request->get('controller', '');
        if ('' !== $controller) {
            $filter['controller'] = new Regex($controller, 'i');
        }

        $route = $request->get('route', '');
        if ('' !== $route) {
            $filter['route'] = new Regex($route, 'i');
        }

        $routeParams = $request->get('routeParams', '');
        if ('' !== $routeParams) {
            $filter['routeParams'] = new Regex($routeParams, 'i');
        }

        $params = $request->get('params', '');
        if ('' !== $params) {
            $filter['params'] = new Regex($params, 'i');
        }
        
        return $filter;
    }
    
    /**    
     * @param string $date
     * @param string $time
     * @return UTCDateTime
     */
    private function parseDateTime(string $date, string $time = '') : UTCDateTime
    {
        $date = explode('T', $date);
        if ($time) {
            $time    = explode('T', $time);
            $date[1] = $time[1];
        }        
        return new UTCDateTime(strtotime(implode(' ', $date)) * 1000);
    }
    
    /**     
     * @param Request $request
     * @return array
     */
    private function parseOptions(Request $request) : array
    {
        $sort = ['createdAt' => -1];
        
        $settings = QueryParams::extractSortingSettings(array_merge(
            $request->request->all(), 
            $request->query->all()
        ));
        
        if (isset($settings['orderKey'])) {
            $key   = $settings['orderKey'];
            $order = $settings['order'] == 'ASC' ? 1 : -1;
            $sort  = [$key => $order];
        }
        
        return [
            'sort'  => $sort,
            'skip'  => (int) $request->get('start', 0),
            'limit' => (int) $request->get('limit', 50),
        ];
    }
}
