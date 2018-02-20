<?php

namespace App\Cache;

/**
 * Class MemcachedStorage.
 */
class MemcachedStorage implements CacheStorageInterface
{
    /**
     * @var \Memcache
     */
    private $storage;

    /**
     * MemcachedStorage constructor.
     * @param array $servers
     */
    public function __construct(array $servers)
    {
        $this->storage = new \Memcache();

        foreach ($servers as list($host, $port)) {
            $this->storage->addServer($host, $port);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function has($code): bool
    {
        return false !== $this->get($code);
    }

    /**
     * {@inheritdoc}
     */
    public function set(string $code, int $value)
    {
        $this->storage->set($code, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function get(string $code): int
    {
        return $this->storage->get($code);
    }

    /**
     * {@inheritdoc}
     */
    public function increment(string $code)
    {
        $this->storage->increment($code);
    }
}