<?php

namespace App\Controller;

use App\Helper\CityHelper;
use App\Helper\WeatherHelper;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class WeatherController
 * @package App\Controller
 */
class WeatherController extends AbstractController
{
    /**
     * @Route("/", name="homepage", methods={"GET"})
     *
     * @return Response
     */
    public function index(): Response
    {
        return $this->redirectToRoute('api_city_weather');
    }

    /**
     * @Route("/city-weather", name="api_city_weather", methods={"GET"})
     * @param WeatherHelper $weatherHelper
     * @param CityHelper $cityHelper
     *
     * @return Response
     */
    public function cityWeather(WeatherHelper $weatherHelper, CityHelper $cityHelper): Response
    {
        $cities = [];

        $citiesLatLong = $cityHelper->getCitiesLatLong();

        foreach ($citiesLatLong as $city) {
            $cityWeather = $weatherHelper->getWeather($city);

            if ($cityWeather) {
                $cities[] = $cityWeather;
            }
        }

        return $this->render('base.html.twig', [
            'cities' => $cities
        ]);
    }
}