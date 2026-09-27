
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
    <div class="news-page" style="max-width:800px;margin:0 auto;padding:20px;font-family:sans-serif;">

        <h1>Latest News</h1>

    <?php if (session()->getFlashdata('message')): ?>
        <p style="color:green;"><?= esc(session()->getFlashdata('message')) ?></p>
    <?php endif ?>
    <?php if (session()->getFlashdata('error')): ?>
        <p style="color:red;"><?= esc(session()->getFlashdata('error')) ?></p>
    <?php endif ?>

    <form action="<?= site_url('auth/news/refresh') ?>" method="post" style="margin-bottom:20px;">
        <?= csrf_field() ?>
        <input type="text" name="country" value="us" placeholder="country e.g. us, gb, za" />
        <input type="text" name="category" placeholder="category (optional)" />
        <button type="submit" class="btn btn-primary">Fetch latest now</button>
    </form>

    <?php if (empty($articles)): ?>
        <p>No articles yet. Run <code>php spark news:fetch</code> or click "Fetch latest now" above.</p>
    <?php endif ?>

    <?php foreach ($articles as $article): ?>
        <article class="feature col" style="display:flex;gap:16px;border-bottom:1px solid #ddd;padding:16px 0;">
            <?php if (!empty($article['image_url'])): ?>
                <img class="feature-icon d-inline-flex align-items-center justify-content-center text-bg-primary bg-gradient fs-2 mb-3" src="<?= esc($article['image_url']) ?>" alt="" style="width:160px;height:100px;object-fit:cover;flex-shrink:0;">
            <?php endif ?>
            <div>
                <h3 style="margin:0 0 6px;">
                    <a href="<?= esc($article['url']) ?>"  target="_blank" rel="noopener">
                        <?= esc($article['title']) ?>
                    </a>
                </h3>
                <p style="margin:0 0 6px;color:#444;"><?= esc($article['description']) ?></p>
                <small style="color:#888;">
                    <?= esc($article['source_name'] ?? 'Unknown source') ?>
                    &middot;
                    <?= !empty($article['published_at']) ? date('d M Y, H:i', strtotime($article['published_at'])) : '' ?>
                </small>
            </div>
        </article>
    <?php endforeach ?>

    <div class="pagination">
        <?= $pager->links() ?>
    </div>

</div>

</body>

</html>
