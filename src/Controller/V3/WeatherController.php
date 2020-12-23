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

        $citiesLatLong = [ '17.82,105.9', '51.52,-0.11', '21.03,105.85', '18.67,105.67', '17.82,105.9'];

        foreach ($citiesLatLong as $city) {
            $cityWeather = $this->getWeather($city);

            if ($cityWeather) {
                $data[] = $cityWeather;
            }
        }

        $response = new Response(json_encode($data));
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    /**
     * @param string $city
     * @return string
     */
    public function getWeather(string $city): string
    {
        $data = '';

        $url = "https://api.weatherapi.com/v1/forecast.json?key=".getenv('API_KEY')."&q=$city&days=2";

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);


        $responseData = json_decode(curl_exec($curl));

        curl_close($curl);

        if (isset($responseData->error)) {
            return $data;
        }

        $cityName        = $responseData->location->name;
        $forecastWeather = $responseData->forecast->forecastday;


        $toDay    = $forecastWeather[0]->day->condition->text;
        $tomorrow = $forecastWeather[1]->day->condition->text;

        $data = 'Processed city ' . '' . $cityName . ' | ' . $toDay . ' - ' . $tomorrow;

        return $data;
    }
}