<?php
require_once __DIR__ . '/../src/Database.php';
require_once __DIR__ . '/../src/Cache.php';
require_once __DIR__ . '/../src/NewsRepository.php';
require_once __DIR__ . '/../src/RssFetcher.php';

try {
    $rssUrl = 'https://ria.ru/export/rss2/archive/index.xml';
    $fetcher = new RssFetcher($rssUrl);
    $newsItems = $fetcher->fetch();

    $repository = new NewsRepository();
    $repository->save($newsItems);

    $cache = new Cache();
    $cache->delete('categories'); // обновляем кеш категорий

    echo "Новости успешно загружены!";
} catch (Exception $e) {
    echo "Ошибка: " . $e->getMessage();
}
