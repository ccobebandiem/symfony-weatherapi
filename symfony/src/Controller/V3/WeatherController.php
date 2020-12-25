<?php

namespace App\Controller\V3;

use Symfony\Component\HttpFoundation\JsonResponse;
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
    public function index(): JsonResponse
    {
        $data = [];

        $citiesLatLong = $this->getCitiesLatLong();

        foreach ($citiesLatLong as $city) {
            $cityWeather = $this->getWeather($city);

            if ($cityWeather) {
                $data[] = $cityWeather;
            }
        }

        return new JsonResponse($data);
    }

    /**
     * @param string $city
     *
     * @return string
     */
    public function getWeather(string $city): string
    {
        $data = '';

        $responseData = $this->getWeatherFromWeatherAPI($city);

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

    /**
     * @return array
     */
    public function getCitiesLatLong(): array
    {
        $data = [];

        $responseData = $this->getCitiesFromMusementAPI();

        if (isset($responseData->error)) {
            return $data;
        }

        foreach ($responseData as $item) {
            $data[] = (string)($item->latitude . ',' . $item->longitude);
        }

        return $data;
    }

    /**
     * @param string $city
     *
     * @return mixed
     */
    public function getWeatherFromWeatherAPI(string $city)
    {
        $url = getenv('API_WEATHER');

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POSTFIELDS, 'key=' . getenv('API_WEATHER_KEY') . "&q=$city&days=2");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $responseData = json_decode(curl_exec($curl));

        curl_close($curl);

        return $responseData;
    }

    /**
     * @return mixed
     */
    public function getCitiesFromMusementAPI()
    {
        $url = getenv('API_MUSEMENT') . "cities?offset=0&limit=10&prioritized_country=10&prioritized_country_cities_limit=10&sort_by=weight&without_events=yes";

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $responseData = json_decode(curl_exec($curl));

        curl_close($curl);

        return $responseData;
    }
}