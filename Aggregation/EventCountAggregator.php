<?php

namespace App\Analytic;

use App\Cache\CacheStorageInterface;
use App\Db\ConnectionInterface;
use App\TimeFrame;

/**
 * Class EventCountAggregator.
 */
final class EventCountAggregator
{
    /**
     * @var CacheStorageInterface
     */
    private $cacheStorage;

    /**
     * @var ConnectionInterface
     */
    private $connection;

    /**
     * StatRepository constructor.
     * @param CacheStorageInterface $cacheStorage
     * @param ConnectionInterface $connection
     */
    public function __construct(CacheStorageInterface $cacheStorage, ConnectionInterface $connection)
    {
        $this->cacheStorage = $cacheStorage;
        $this->connection = $connection;
    }

    /**
     * @param TimeFrame $frame
     *
     * @return int
     */
    public function getValue(TimeFrame $frame): int
    {
        $frameCode = $frame->getHashCode();
        $cachedValue = $this->getValueFromCache($frame);

        if (null !== $cachedValue) {
            return $cachedValue;
        }

        $dbValue = $this->getValueFromDb($frame);
        $this->cacheStorage->set($frameCode, $dbValue);

        return $dbValue;
    }

    /**
     * @param TimeFrame $frame
     */
    public function incrementValue(TimeFrame $frame)
    {
        $this->cacheStorage->increment($frame->getHashCode());
    }

    /**
     * @param TimeFrame $frame
     *
     * @return int|null
     */
    private function getValueFromCache(TimeFrame $frame): ?int
    {
        $frameCode = $frame->getHashCode();

        if ($this->cacheStorage->has($frameCode)) {
            return $this->cacheStorage->get($frameCode);
        }

        return null;
    }

    /**
     * @param TimeFrame $frame
     *
     * @return int
     */
    private function getValueFromDb(TimeFrame $frame): int
    {
        $sql = 'SELECT COUNT(id) as cnt FROM event WHERE created_at BETWEEN ? AND ?';

        $result = $this->connection->fetchArray($sql, [
            $frame->getStartDate()->format('Y-m-d H:i:s'),
            $frame->getEndDate()->format('Y-m-d H:i:s'),
        ]);

        return $result[0]['cnt'];
    }
}