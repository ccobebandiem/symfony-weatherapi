<?php


namespace App\Tests\Command;

use App\Helper\WeatherHelper;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class WeatherHelperTest extends KernelTestCase
{
    /**
     * @var WeatherHelper
     */
    private $weatherHelper;

    protected function setUp()
    {
        self::bootKernel();
        $this->weatherHelper = self::$container->get('App\Helper\WeatherHelper');
    }

    /**
     * @dataProvider providedCities
     */
    public function testGetWeather($city)
    {
        $latLong = $city[0];
        $cityName = $city[1];

        $result = $this->weatherHelper->getWeather($latLong);
        $this->assertEquals($result['cityName'], $cityName);
    }

    public function providedCities() : array
    {
        return [
            [['48.21,16.367', 'Inner City']],
            [['47.268,11.405', 'Innsbruck']],
            [['48.6137566,12.9336109', 'Rengwartling']],
            [['47.2935782,11.6004114', 'Wattenberg']],
            [['46.613907,14.041718', 'Velden Am Wortherseen']],
        ];
    }
}
