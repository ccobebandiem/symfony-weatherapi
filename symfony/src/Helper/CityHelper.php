<?php

namespace App\Helper;

use Symfony\Contracts\HttpClient\HttpClientInterface;


class CityHelper
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
     * @return array
     */
    public function getCitiesLatLong($limit = 10): array
    {
        $data = [];

        $responseData = $this->client->request(
            'GET',
            getenv('MUSEMENT_API_ENDPOINT') . "cities",
            [
                'query' => [
                    'offset'                           => 0,
                    'limit'                            => $limit,
                    'prioritized_country'              => 10,
                    'prioritized_country_cities_limit' => 10,
                    'sort_by'                          => 'weight',
                    'without_events'                   => 'yes'
                ]
            ]
        );

        if ($responseData->getStatusCode() !== 200) {
            return $data;
        }

        $responseData = json_decode($responseData->getContent());

        foreach ($responseData as $item) {
            $data[] = (string)($item->latitude . ',' . $item->longitude);
        }

        return $data;
    }
}