<?php


namespace App\Helper;

use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;


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
    public function getCitiesLatLong($limit): array
    {
        $data = [];

        $responseData = $this->getCitiesFromMusementAPI($limit);

        if ($responseData->getStatusCode() !== 200) {
            return $data;
        }

        $responseData = json_decode($responseData->getContent());

        foreach ($responseData as $item) {
            $data[] = (string)($item->latitude . ',' . $item->longitude);
        }

        return $data;
    }

    /**
     * @param int $limit
     *
     * @return ResponseInterface
     * @throws TransportExceptionInterface
     */
    public function getCitiesFromMusementAPI($limit): ResponseInterface
    {
        return $this->client->request(
            'GET',
            getenv('API_MUSEMENT') . "cities",
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
    }
}