<?php

namespace App\Cache;

/**
 * Abstraction around any NoSQL storage (Redis, Memcached).
 */
interface CacheStorageInterface
{
    /**
     * @param string $code
     *
     * @return bool
     */
    public function has($code): bool;

    /**
     * @param string $code
     * @param int $value
     */
    public function set(string $code, int $value);

    /**
     * @param string $code
     *
     * @return int
     */
    public function get(string $code): int;

    /**
     * @param string $code
     */
    public function increment(string $code);
}