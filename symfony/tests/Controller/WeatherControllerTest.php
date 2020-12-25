<?php


namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class WeatherControllerTest extends WebTestCase
{
    public function testIndexFunctionCase001()
    {
        $client = static::createClient();

        $client->request('GET', '/api/v3/test');

        $this->assertCount(10, json_decode($client->getResponse()->getContent(), true));
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testIndexFunctionCase002()
    {
        $client = static::createClient();

        $client->request('GET', '/api/v3/test/5');

        $this->assertCount(5, json_decode($client->getResponse()->getContent(), true));
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testIndexFunctionCase003()
    {
        $client = static::createClient();

        $client->request('GET', '/api/v3/test/0');

        $this->assertEquals([], json_decode($client->getResponse()->getContent(), true));
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testIndexFunctionCase004()
    {
        $client = static::createClient();

        $client->request('GET', '/api/v3/test/test');

        $this->assertEquals(404, $client->getResponse()->getStatusCode());
    }
}