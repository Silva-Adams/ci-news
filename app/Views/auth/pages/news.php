
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Latest News</title>
    <link rel="stylesheet" href="<?php echo base_url('styles/news_style.css'); ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>
<body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>


    <?php if (!empty($articles)): ?>
        <div class="container mt-5">
            <h1 class="mb-4">Latest News</h1>
            <div class="row">
                <?php foreach ($articles as $article): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <?php if (!empty($article['urlToImage'])): ?>
                                <img src="<?php echo esc($article['urlToImage']); ?>" class="card-img-top" alt="News Image">
                            <?php endif; ?>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo esc($article['title']); ?></h5>
                                <p class="card-text"><?php echo esc($article['description']); ?></p>
                                <a href="<?php echo esc($article['url']); ?>" target="_blank" class="btn btn-primary">Read More</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php else: ?>
        <div class="container mt-5">
            <h1 class="mb-4">No news articles available.</h1>
        </div>
    <?php endif; ?> 
</body>
</html>
