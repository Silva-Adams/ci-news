<?php

namespace App\Controllers;

use App\Models\NewsModel;
use App\Libraries\NewsApiService;

class News extends BaseController
{
    protected NewsModel $newsModel;

    public function __construct()
    {
        $this->newsModel = new NewsModel();
    }

    /**
     * GET /news
     * Lists stored articles, newest first, paginated.
     */
    public function index()
    {
        $data = [
            'articles' => $this->newsModel->getLatest(20),
            'pager'    => $this->newsModel->pager,
        ];

        return view('auth/news/index', $data);
    }

    /**
     * POST /news/refresh
     * Lets a logged-in admin (or anyone, if you don't gate it) trigger an
     * on-demand fetch from the browser instead of waiting for the cron job.
     */
    public function refresh()
    {
        $service = new NewsApiService();

        $country  = $this->request->getPost('country') ?? 'us';
        $category = $this->request->getPost('category');

        try {
            $articles = $service->fetchTopHeadlines($country, $category);
            $inserted = $this->newsModel->upsertArticles($articles);
        } catch (\Throwable $e) {
            return redirect()->to('auth/news')->with('error', $e->getMessage());
        }

        return redirect()->to('auth/news')->with(
            'message',
            "Fetched " . count($articles) . " articles, added {$inserted} new."
        );
    }
}
