<?php
/**
 * @category    pimcore5-user-tracking
 * @date        26/09/2017
 * @author      Korneliusz Kirsz <kkirsz@divante.pl>
 * @copyright   Copyright (c) 2017 DIVANTE (http://divante.pl)
 */

declare(strict_types=1);

namespace Divante\TrackingBundle\Controller;

use Divante\TrackingBundle\Helper\ConfigHelper;
use Pimcore\Controller\FrontendController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ConfigController
 * @package Divante\TrackingBundle\Controller
 * @Route("/user-tracking-config")
 */
class ConfigController extends FrontendController
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        $this->view->config = ConfigHelper::get();
    }

    /**
     * @param Request $request
     * @return Response
     * @Route("/save")
     */
    public function saveAction(Request $request) : Response
    {
        ConfigHelper::put([
            'username' => $request->get('username', ConfigHelper::DEFAULT_USERNAME),
            'password' => $request->get('password', ConfigHelper::DEFAULT_PASSWORD),
            'host'     => $request->get('host', ConfigHelper::DEFAULT_HOST),
            'port'     => $request->get('port', ConfigHelper::DEFAULT_PORT),
            'database' => $request->get('database', ConfigHelper::DEFAULT_DATABASE),
        ]);
        return new Response('Configuration saved');
    }
}
