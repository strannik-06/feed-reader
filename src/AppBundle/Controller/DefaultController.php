<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Service\FeedReader;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     *
     * @return Response
     */
    public function indexAction(Request $request)
    {
        return $this->render('AppBundle:Default:index.html.twig');
    }

    /**
     * @Route("/feed", defaults={"_format": "json"}, name="feed")
     *
     * @return Response
     */
    public function feedAction(Request $request)
    {
        $xmlPath = $request->get('source');
        $xmlPath = "http://pf.tradetracker.net/?aid=1&type=xml&encoding=utf-8&fid=251713&categoryType=2&additionalType=2";
        $xmlPath = "http://pf.tradetracker.net/?aid=1&type=xml&encoding=utf-8&fid=251713&categoryType=2&additionalType=2&limit=10";
        /** @var FeedReader $feedService */
        $feedService = $this->get('app.feed');

        return new JsonResponse($feedService->processXml($xmlPath));
    }
}
