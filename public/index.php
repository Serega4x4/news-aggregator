<?php
require_once __DIR__ . '/../src/Database.php';
require_once __DIR__ . '/../src/Cache.php';
require_once __DIR__ . '/../src/NewsRepository.php';

$repository = new NewsRepository();
$cache = new Cache();

// Фильтры
$category = $_GET['category'] ?? null;
$date = $_GET['date'] ?? null;

// Генерация ключа кеша
$cacheKey = "news_" . md5($category . '_' . $date);
$news = $cache->get($cacheKey);

if (!$news) {
    $news = $repository->getNews($category, $date);
    $cache->set($cacheKey, $news, 300); // кешируем на 5 минут
}

// Кеширование категорий отдельно
$categories = $cache->get('categories');
if (!$categories) {
    $categories = $repository->getCategories();
    $cache->set('categories', $categories, 600);
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Новостной агрегатор</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-5">
    <h1>Новости</h1>

    <form method="GET" class="row g-3 mb-4">
        <div class="col-md-4">
            <select name="category" class="form-select">
                <option value="">Все категории</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= htmlspecialchars($cat) ?>" <?= $category === $cat ? 'selected' : '' ?>>
                        <?= htmlspecialchars($cat) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="col-md-4">
            <input type="date" name="date" value="<?= htmlspecialchars($date) ?>" class="form-control">
        </div>
        <div class="col-md-4">
            <button type="submit" class="btn btn-primary">Фильтр</button>
        </div>
    </form>

    <?php foreach ($news as $item): ?>
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title"><?= htmlspecialchars($item['title']) ?></h5>
                <h6 class="card-subtitle mb-2 text-muted"><?= htmlspecialchars($item['pubDate']) ?> — <?= htmlspecialchars($item['category']) ?></h6>
                <p class="card-text"><?= htmlspecialchars(strip_tags($item['description'])) ?></p>
                <a href="<?= htmlspecialchars($item['link']) ?>" target="_blank" class="card-link">Читать полностью</a>
            </div>
        </div>
    <?php endforeach; ?>
</body>
</html>
