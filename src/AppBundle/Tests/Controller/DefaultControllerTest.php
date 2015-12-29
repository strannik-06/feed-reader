<?php

namespace AppBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\Client;

/**
 * Test for AppBundle\Controller\DefaultController.php
 */
class DefaultControllerTest extends WebTestCase
{
    /**
     * @var Client
     */
    private $client;

    /**
     * Set up
     */
    public function setUp()
    {
        $this->client = static::createClient();
    }

    /**
     * Test for AppBundle\Controller\DefaultController::indexAction
     */
    public function testIndex()
    {
        $crawler = $this->client->request('GET', '/');

        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertContains('Feed Reader', $crawler->filter('h2')->text());
        $this->assertContains('Get data', $crawler->filter('button')->text());
    }

    /**
     * Test for AppBundle\Controller\DefaultController::feedAction
     * Also test performance - Any PHP used should be limited to 32MB of memory
     *
     * @param string  $source
     * @param integer $start
     * @param integer $amount
     * @param integer $expectedAmount
     *
     * @dataProvider feedDataProvider
     */
    public function testFeed($source, $start, $amount, $expectedAmount)
    {
        $this->client->request('GET', '/feed', array(
            'source' => $source,
            'start' => $start,
            'amount' => $amount,
        ));

        $response = $this->client->getResponse();
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('application/json', $response->headers->get('Content-type'));
        $this->assertCount($expectedAmount, json_decode($response->getContent(), true));
        $this->assertLessThan(1024 * 1024 * 32, memory_get_peak_usage(true)); // 32 MB
    }

    /**
     * @return array
     */
    public function feedDataProvider()
    {
        return array(
            'small xml' => array(
                'source' => 'http://pf.tradetracker.net/?aid=1&type=xml&encoding=utf-8&fid=251713&categoryType=2'
                    . '&additionalType=2&limit=10',
                'start' => 0,
                'amount' => 100,
                'expectedAmount' => 10,
            ),
            'big xml beginning' => array(
                'source' => 'http://pf.tradetracker.net/?aid=1&type=xml&encoding=utf-8&fid=251713&categoryType=2'
                    . '&additionalType=2&limit=20000',
                'start' => 0,
                'amount' => 100,
                'expectedAmount' => 100,
            ),
            'big xml end' => array(
                'source' => 'http://pf.tradetracker.net/?aid=1&type=xml&encoding=utf-8&fid=251713&categoryType=2'
                    . '&additionalType=2&limit=20000',
                'start' => 19900,
                'amount' => 100,
                'expectedAmount' => 100,
            ),
        );
    }
}
