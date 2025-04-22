<?php
class NewsRepository
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    public function save(array $news): void
    {
        foreach ($news as $item) {
            $stmt = $this->db->prepare("SELECT COUNT(*) FROM news WHERE link = :link");
            $stmt->execute(['link' => $item['link']]);
            if ($stmt->fetchColumn() == 0) {
                $insert = $this->db->prepare("
                    INSERT INTO news (title, link, description, category, pub_date)
                    VALUES (:title, :link, :description, :category, :pub_date)
                ");
                $insert->execute([
                    'title' => $item['title'],
                    'link' => $item['link'],
                    'description' => $item['description'],
                    'category' => $item['category'],
                    'pub_date' => $item['pub_date'],
                ]);
            }
        }
    }

    public function getNews(?string $category = null, ?string $date = null): array
    {
        $query = "SELECT * FROM news WHERE 1";
        $params = [];

        if ($category) {
            $query .= " AND category = :category";
            $params['category'] = $category;
        }
        if ($date) {
            $query .= " AND DATE(pub_date) = :date";
            $params['date'] = $date;
        }

        $query .= " ORDER BY pub_date DESC";

        $stmt = $this->db->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCategories(): array
    {
        $stmt = $this->db->query("SELECT DISTINCT category FROM news");
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
}
