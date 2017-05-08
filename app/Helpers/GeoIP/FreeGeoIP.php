<?php

namespace Chemlab\Helpers\GeoIP;

use Exception;
use Torann\GeoIP\Services\AbstractService;
use Torann\GeoIP\Support\HttpClient;

class FreeGeoIP extends AbstractService
{
    /**
     * Http client instance.
     *
     * @var HttpClient
     */
    protected $client;

    /**
     * The "booting" method of the service.
     *
     * @return void
     */
    public function boot()
    {
        $base = [
            'base_uri' => 'https://freegeoip.net/',
            'headers' => [
                'User-Agent' => 'Laravel-GeoIP',
            ],
            'query' => [
                'fields' => 49663,
            ],
        ];

        $this->client = new HttpClient($base);
    }

    /**
     * {@inheritdoc}
     */
    public function locate($ip)
    {
        // Get data from client
        $data = $this->client->get('json/' . $ip);

        // Verify server response
        if ($this->client->getErrors() !== null) {
            throw new Exception('Request failed (' . $this->client->getErrors() . ')');
        }

        // Parse body content
        $json = json_decode($data[0]);

        return $this->hydrate([
            'ip' => $ip,
            'iso_code' => $json->country_code,
            'country' => $json->country_name,
            'city' => $json->city,
            'state' => $json->region_code,
            'state_name' => $json->region_name,
            'postal_code' => $json->zip_code,
            'lat' => $json->latitude,
            'lon' => $json->longitude,
            'timezone' => $json->time_zone,
        ]);
    }
}