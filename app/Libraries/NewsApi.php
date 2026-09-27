<?php
namespace App\Libraries;

class NewsApi
{
    private $client;
    private $apiKey = 'e3c07483a42a40bf93e76f84b7fdf735';

    public function __construct()
    {
        $this->client = \Config\Services::curlrequest();
    }

    public function getTopHeadlines($country = 'us')
    {
        $response = $this->client->get('https://newsapi.org/v2/top-headlines?country=' . $country . '&apiKey=' . $this->apiKey,
        [
            'query' => [
                'country' => $country,
                'apiKey' => $this->apiKey
            ]
        ]);
        return json_decode($response->getBody(), true);
    }
}
