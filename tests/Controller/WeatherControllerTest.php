<?php


namespace App\Tests\Controller;

use App\Controller\V3\WeatherController;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class WeatherControllerTest extends WebTestCase
{
    public function testGetWeather()
    {
        $weather = new WeatherController();

        $this->assertNotNull($weather->index());
        $this->assertIsString($weather->index()->getContent());
        $this->assertStringContainsString('London', $weather->getWeather('London'));
        $this->assertStringContainsString('London', $weather->getWeather('51.52,-0.11'));
        $this->assertTrue($weather->getWeather('') === '');
        $this->assertStringNotContainsString('Ha Noi', $weather->getWeather('London'));
        $this->assertStringNotContainsString('Ha Noi', $weather->getWeather('51.52,-0.11'));
    }
}