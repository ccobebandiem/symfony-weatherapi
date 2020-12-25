<?php

namespace App\Controller\V3;

use App\Helper\CityHelper;
use App\Helper\WeatherHelper;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class WeatherController
 * @package App\Controller\V3
 */
class WeatherController
{
    /**
     * @Route("/test/{limit}", name="api_weather_city", methods={"GET"}, requirements={"limit"="\d+"})
     * @param WeatherHelper $weatherHelper
     * @param CityHelper $cityHelper
     * @param int $limit
     *
     * @return JsonResponse
     */
    public function index(WeatherHelper $weatherHelper, CityHelper $cityHelper, $limit = 10): JsonResponse
    {
        $data = [];

        $citiesLatLong = $cityHelper->getCitiesLatLong($limit);

        foreach ($citiesLatLong as $city) {
            $cityWeather = $weatherHelper->getWeather($city);

            if ($cityWeather) {
                $data[] = $cityWeather;
            }
        }

        return new JsonResponse($data);
    }
}