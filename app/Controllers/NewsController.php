<?php

namespace App\Controllers;
use App\Libraries\NewsApi;

class NewsController extends BaseController
{
    private $newsApi;

    public function __construct()
    {
        $this->newsApi = new NewsApi();
    }

    public function index()
    {
        $client = \Config\Services::curlrequest();

        try {
            $response = $client->get('https://newsapi.org/v2/top-headlines?country=us&apiKey=e3c07483a42a40bf93e76f84b7fdf735',
            [
                'query' => [
                    'country' => 'us',
                    'apiKey' => 'e3c07483a42a40bf93e76f84b7fdf735'
                ]
            ]
        );
        $data = json_decode($response->getBody(), true);
        return view('auth/pages/news', $this->newsApi->getTopHeadlines('us'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}
