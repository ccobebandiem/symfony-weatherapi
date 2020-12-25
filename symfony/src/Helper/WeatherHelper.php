<?php

namespace App\Helper;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class WeatherHelper
{
    /**
     * @var HttpClientInterface
     */
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
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

        if ($responseData->getStatusCode() !== 200) {
            return $data;
        }

        $responseData = json_decode($responseData->getContent());

        $cityName        = $responseData->location->name;
        $forecastWeather = $responseData->forecast->forecastday;


        $toDay    = $forecastWeather[0]->day->condition->text;
        $tomorrow = $forecastWeather[1]->day->condition->text;

        $data = 'Processed city ' . '' . $cityName . ' | ' . $toDay . ' - ' . $tomorrow;

        return $data;
    }

    /**
     * @param string $city
     *
     * @return ResponseInterface
     */
    public function getWeatherFromWeatherAPI(string $city): ResponseInterface
    {
        return $this->client->request(
            'GET',
            getenv('API_WEATHER'),
            [
                'query' => [
                    'key'  => getenv('API_WEATHER_KEY'),
                    'q'    => $city,
                    'days' => 2,
                ]
            ]
        );
    }
}