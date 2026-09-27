<?php

namespace App\Models;
use CodeIgniter\Model;

class NewsModel extends Model
{
    protected $table            = 'news';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;

    protected $allowedFields = [
        'external_id',
        'title',
        'description',
        'content',
        'url',
        'image_url',
        'source_name',
        'author',
        'published_at',
    ];

    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Paginated list, newest first.
     */
    public function getLatest(int $perPage = 20)
    {
        return $this->orderBy('published_at', 'DESC')
                    ->orderBy('id', 'DESC')
                    ->paginate($perPage);
    }

    /**
     * Insert a batch of articles from the API, skipping ones we already have
     * (matched on external_id, which is a hash of the article URL).
     */
    public function upsertArticles(array $articles): int
    {
        $inserted = 0;

        foreach ($articles as $article) {
            $exists = $this->where('external_id', $article['external_id'])->first();

            if ($exists) {
                continue;
            }

            $this->insert($article);
            $inserted++;
        }

        return $inserted;
    }
}
