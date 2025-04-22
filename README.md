# Новостной агрегатор

## Требования
- PHP 8+
- MySQL
- Memcached

## Установка
1. Установить необходимые пакеты: 
```bash
sudo apt update
sudo apt install php php-mysql php-memcached php-xml php-cli php-curl php-mbstring php-zip mysql-server memcached
```  
2. Клонировать проект:  
```bash
git clone https://github.com/Serega4x4/news-aggregator.git
cd news-aggregator
```  
3. Настроить базу данных:  
Запусти MySQL:  
```bash
sudo mysql
```  
В консоли MySQL выполни команды для создания базы и таблицы:  
```sql
CREATE DATABASE news_aggregator CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE news_aggregator;

CREATE TABLE news (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    link VARCHAR(500) NOT NULL,
    pub_date DATETIME,
    category VARCHAR(255)
);

CREATE INDEX idx_pub_date ON news(pub_date);
CREATE INDEX idx_category ON news(category);

EXIT;
```  
4. Настроить подключение к базе данных  `/src/Database.php`  

5. Запустить сервер  
Перейди в папку `public`:  
```bash
cd public
```  
Запусти встроенный сервер PHP:  
```bash
php -S localhost:8000
```  
6. Сайт доступен по ссылке:  
```bash
http://localhost:8000
```
# news-aggregator
