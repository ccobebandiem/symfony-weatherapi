<?php

namespace App\Controller\V3;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class WeatherController
 * @package App\Controller\V3
 */
class WeatherController
{
    /**
     * @Route("/test", name="api_weather_city", methods={"GET"})
     */
    public function index(): Response
    {
        $data = [];

        $url = 'https://api.weatherapi.com/v1/forecast.json?key=7a1209ad53ca417ab7564558202212&q=London&days=2';

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $responseData = json_decode(curl_exec($curl));
        curl_close($curl);

        $cityName        = $responseData->location->name;
        $forecastWeather = $responseData->forecast->forecastday;


        $toDay    = $forecastWeather[0]->day->condition->text;
        $tomorrow = $forecastWeather[1]->day->condition->text;

        $row = 'Processed city ' . '' . $cityName . ' | ' . $toDay . ' - ' . $tomorrow;

        $data[] = $row;

        $response = new Response(json_encode($data));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}