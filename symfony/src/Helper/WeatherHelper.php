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
     * @return array
     */
    public function getWeather(string $city): array
    {

        $data = [];

        $responseData = $this->getWeatherFromWeatherAPI($city);

        if (!$responseData || $responseData->getStatusCode() !== 200) {
            return $data;
        }

        $responseData = json_decode($responseData->getContent());

        $cityName        = $responseData->location->name;
        $forecastWeather = $responseData->forecast->forecastday;
        $todayWeather    = count($forecastWeather) > 0 ? $forecastWeather[0]->day->condition->text : null;
        $tomorrowWeather = count($forecastWeather) > 1 ? $forecastWeather[1]->day->condition->text : null;

        $data = [
            'cityName'        => $cityName,
            'todayWeather'    => $todayWeather,
            'tomorrowWeather' => $tomorrowWeather
        ];

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
            getenv('WEATHER_API_ENDPOINT'),
            [
                'query' => [
                    'key'  => getenv('WEATHER_API_KEY'),
                    'q'    => $city,
                    'days' => 2,
                ]
            ]
        );
    }
}