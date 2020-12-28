<?php


namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class WeatherControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/city-weather');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertEquals($crawler->filter('p:contains("Processed city")')->count(), 10);
    }
}