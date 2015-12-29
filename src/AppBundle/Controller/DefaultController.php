<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Service\Feed\Reader;

class DefaultController extends Controller
{
    /**
     * @param Request $request
     *
     * @Route("/", name="homepage")
     *
     * @return Response
     */
    public function indexAction(Request $request)
    {
        return $this->render('AppBundle:Default:index.html.twig');
    }

    /**
     * @param Request $request
     *
     * @Route("/feed", defaults={"_format": "json"}, name="feed")
     *
     * @return Response
     */
    public function feedAction(Request $request)
    {
        $xmlPath = $request->get('source');
        $start = $request->get('start', 0);
        $amount = $request->get('amount', 100);
        $xmlPath = "http://pf.tradetracker.net/?aid=1&type=xml&encoding=utf-8&fid=251713&categoryType=2&additionalType=2";

        /** @var Reader $feedService */
        $feedService = $this->get('app.feed');

        return new JsonResponse($feedService->processXml($xmlPath, $start, $amount));
    }
}
