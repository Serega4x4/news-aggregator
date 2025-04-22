CREATE DATABASE IF NOT EXISTS news_aggregator CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE news_aggregator;

CREATE TABLE IF NOT EXISTS news (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(500) NOT NULL,
    link VARCHAR(1000) NOT NULL UNIQUE,
    description TEXT,
    category VARCHAR(255),
    pubDate DATETIME,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX (category),
    INDEX (pubDate)
);
