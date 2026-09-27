<?php

namespace App\Libraries;

use Config\Services;

/**
 * Thin wrapper around NewsAPI.org's /v2/top-headlines and /v2/everything endpoints.
 *
 * Requires an API key from https://newsapi.org, stored in .env as:
 *   NEWSAPI_KEY=your_key_here
 */
class NewsApiService
{
    protected string $baseUrl = 'https://newsapi.org/v2/';
    protected string $apiKey;
    protected $client;

   public function __construct()
{
    $this->apiKey = env('NEWSAPI_KEY', '');

    $this->client = Services::curlrequest([
        'timeout' => 10,
        'headers' => [
            // NewsAPI rejects requests with no User-Agent ("userAgentMissing").
            'User-Agent' => 'CI-News-App (+https://localhost/ci-news)',
        ],
    ]);
}

    /**
     * Fetch top headlines and return them normalized for the `news` table.
     *
     * @param string $country e.g. 'us', 'gb', 'za'
     * @param string|null $category e.g. 'technology', 'business', 'sports'
     */
     public function fetchTopHeadlines(string $country = 'us', ?string $category = null): array
    {
        if (empty($this->apiKey)) {
            throw new \RuntimeException('NEWSAPI_KEY is not set in .env');
        }

        $query = [
            'country' => $country,
            'apiKey'  => $this->apiKey,
            'pageSize' => 100,
        ];

        if ($category) {
            $query['category'] = $category;
        }

        $response = $this->client->get($this->baseUrl . 'top-headlines', [
            'query'       => $query,
            'http_errors' => false, // don't throw on 4xx/5xx, let us read the body
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Search articles by keyword (uses the /everything endpoint).
     */
    public function search(string $keyword, string $sortBy = 'publishedAt'): array
    {
        if (empty($this->apiKey)) {
            throw new \RuntimeException('NEWSAPI_KEY is not set in .env');
        }

        $query = [
            'q'       => $keyword,
            'sortBy'  => $sortBy,
            'apiKey'  => $this->apiKey,
            'pageSize' => 100,
            'language' => 'en',
        ];

        $response = $this->client->get($this->baseUrl . 'everything', [
            'query'       => $query,
            'http_errors' => false,
        ]);

        return $this->handleResponse($response);
    }

    /**
     * Parse a NewsAPI response, surfacing the API's own error message
     * (and the HTTP status) instead of a generic cURL exception.
     */
    protected function handleResponse($response): array
    {
        $status = $response->getStatusCode();
        $body   = json_decode($response->getBody(), true);

        $this->lastMeta = [
            'httpStatus'   => $status,
            'apiStatus'    => $body['status'] ?? null,
            'totalResults' => $body['totalResults'] ?? null,
            'code'         => $body['code'] ?? null,
            'message'      => $body['message'] ?? null,
        ];

        if ($status !== 200 || ($body['status'] ?? null) !== 'ok') {
            $code    = $body['code'] ?? $status;
            $message = $body['message'] ?? 'Unknown error (empty response body)';
            throw new \RuntimeException("NewsAPI error [HTTP {$status}, code: {$code}]: {$message}");
        }

        return $this->normalize($body['articles'] ?? []);
    }

    /**
     * Map NewsAPI's raw article shape onto our `news` table columns.
     */
    protected function normalize(array $articles): array
    {
        $rows = [];

        foreach ($articles as $article) {
            $url = $article['url'] ?? null;

            if (!$url) {
                continue;
            }

            $rows[] = [
                'external_id'  => md5($url),
                'title'        => substr($article['title'] ?? 'Untitled', 0, 500),
                'description'  => $article['description'] ?? null,
                'content'      => $article['content'] ?? null,
                'url'          => $url,
                'image_url'    => $article['urlToImage'] ?? null,
                'source_name'  => $article['source']['name'] ?? null,
                'author'       => $article['author'] ?? null,
                'published_at' => !empty($article['publishedAt'])
                    ? date('Y-m-d H:i:s', strtotime($article['publishedAt']))
                    : null,
            ];
        }

        return $rows;
    }
}
