<?php
class Cache
{
    private Memcached $memcached;

    public function __construct()
    {
        $config = require __DIR__ . '/../config/memcached.php';
        $this->memcached = new Memcached();
        $this->memcached->addServer($config['host'], $config['port']);
    }

    public function get(string $key)
    {
        return $this->memcached->get($key);
    }

    public function set(string $key, $value, int $ttl = 300)
    {
        return $this->memcached->set($key, $value, $ttl);
    }

    public function delete(string $key)
    {
        return $this->memcached->delete($key);
    }
}
