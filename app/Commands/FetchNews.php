<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use App\Libraries\NewsApiService;
use App\Models\NewsModel;

/**
 * Run manually with:
 *   php spark news:fetch
 *   php spark news:fetch --country=za --category=technology
 *
 * Run automatically (dynamic updates) by adding this to your crontab,
 * e.g. every 15 minutes:
 *   *//*15 * * * * php /path/to/project/spark news:fetch >> /path/to/project/writable/logs/news-cron.log 2>&1
 */
class FetchNews extends BaseCommand
{
    protected $group       = 'news';
    protected $name        = 'news:fetch';
    protected $description = 'Fetch the latest headlines from NewsAPI.org and store new articles in the database.';
    protected $usage       = 'news:fetch [options]';
    protected $options     = [
        '--country'  => 'Country code, e.g. us, gb, za (default: us)',
        '--category' => 'Category, e.g. business, technology, sports',
        '--q'        => 'Keyword search instead of top headlines',
    ];

    public function run(array $params)
    {
        $service = new NewsApiService();
        $model   = new NewsModel();

        $country  = CLI::getOption('country') ?? 'us';
        $category = CLI::getOption('category');
        $keyword  = CLI::getOption('q');

        try {
            if ($keyword) {
                CLI::write("Searching NewsAPI for \"{$keyword}\"...", 'yellow');
                $articles = $service->search($keyword);
            } else {
                CLI::write("Fetching top headlines (country={$country}" . ($category ? ", category={$category}" : '') . ")...", 'yellow');
                $articles = $service->fetchTopHeadlines($country, $category);
            }
        } catch (\Throwable $e) {
            CLI::error('Failed to fetch news: ' . $e->getMessage());
            return;
        }

        $inserted = $model->upsertArticles($articles);

        CLI::write("NewsAPI reported totalResults: " . ($service->lastMeta['totalResults'] ?? 'n/a'), 'cyan');
        CLI::write("Fetched " . count($articles) . " articles, added {$inserted} new.", 'green');
    }
}
