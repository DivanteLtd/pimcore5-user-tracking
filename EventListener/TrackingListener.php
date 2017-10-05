<?php
/**
 * @category    pimcore5-user-tracking
 * @date        26/09/2017
 * @author      Korneliusz Kirsz <kkirsz@divante.pl>
 * @copyright   Copyright (c) 2017 DIVANTE (http://divante.pl)
 */

namespace Divante\TrackingBundle\EventListener;

use Divante\TrackingBundle\Model\UserTrack;
use Divante\TrackingBundle\Model\UserTrackRepository;
use Pimcore\Bundle\AdminBundle\Security\User\TokenStorageUserResolver;
use Pimcore\Bundle\CoreBundle\EventListener\Traits\PimcoreContextAwareTrait;
use Pimcore\Service\Request\PimcoreContextResolver;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * Class TrackingListener
 * @package Divante\TrackingBundle\EventListener
 * @see \Pimcore\Bundle\AdminBundle\EventListener\UsageStatisticsListener
 */
class TrackingListener implements EventSubscriberInterface
{
    use PimcoreContextAwareTrait;

    /**
     * @var TokenStorageUserResolver
     */
    protected $userResolver;

    /**
     * @var UserTrackRepository
     */
    protected $repository;

    /**
     * @param TokenStorageUserResolver $userResolver
     */
    public function __construct(TokenStorageUserResolver $userResolver)
    {
        $this->userResolver = $userResolver;
        $this->repository   = new UserTrackRepository();
    }

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => 'onKernelRequest'
        ];
    }

    /**
     * @param GetResponseEvent $event
     */
    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();

        if (!$event->isMasterRequest()) {
            return;
        }

        if (!$this->matchesPimcoreContext($request, PimcoreContextResolver::CONTEXT_ADMIN)) {
            return;
        }

        $this->logUsageStatistics($request);
    }

    /**
     * @param Request $request
     */
    protected function logUsageStatistics(Request $request)
    {
        $user   = $this->userResolver->getUser();
        $params = $this->getParams($request);

        $userId      = $user ? (int) $user->getId() : 0;
        $controller  = $request->attributes->get('_controller');
        $route       = $request->attributes->get('_route');
        $routeParams = @json_encode($request->attributes->get('_route_params'));
        $params      = @json_encode($params);

        $userTrack = new UserTrack(
            $userId,
            $controller,
            $route,
            $routeParams,
            $params
        );

        try {
            $this->repository->add($userTrack);
        } catch (\Exception $ex) {
            //TODO:log
        }
    }

    /**
     * @param Request $request
     * @return array
     */
    protected function getParams(Request $request) : array
    {
        $params = [];
        $disallowedKeys = ['_dc', 'module', 'controller', 'action', 'password'];

        $requestParams = array_merge(
            $request->query->all(),
            $request->request->all()
        );

        foreach ($requestParams as $key => $value) {
            if (is_json($value)) {
                $value = json_decode($value);
                if (is_array($value)) {
                    array_walk_recursive($value, function (&$item, $key) {
                        if (strpos($key, 'pass') !== false) {
                            $item = '*************';
                        }
                    });
                }

                $value = json_encode($value);
            }

            if (!in_array($key, $disallowedKeys) && is_string($value)) {
                $params[$key] = $value;
            }
        }

        return $params;
    }
}
