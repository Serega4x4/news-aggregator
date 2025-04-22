<?php
class RssFetcher
{
    private string $rssUrl;

    public function __construct(string $rssUrl)
    {
        $this->rssUrl = $rssUrl;
    }

    public function fetch(): array
    {
        $content = file_get_contents($this->rssUrl);
        if (!$content) {
            throw new Exception("Не удалось загрузить RSS.");
        }

        $rss = simplexml_load_string($content);
        $news = [];
        foreach ($rss->channel->item as $item) {
            $news[] = [
                'title' => (string) $item->title,
                'link' => (string) $item->link,
                'description' => (string) $item->description,
                'category' => (string) $item->category,
                'pubDate' => date('Y-m-d H:i:s', strtotime((string) $item->pubDate)),
            ];
        }
        return $news;
    }
}
