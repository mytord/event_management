<?php

namespace App\Aggregation;

use App\Cache\CacheStorageInterface;
use App\Repository\EventRepositoryInterface;
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
     * @var EventRepositoryInterface
     */
    private $eventRepository;

    /**
     * EventCountAggregator constructor.
     * @param CacheStorageInterface $cacheStorage
     * @param EventRepositoryInterface $eventRepository
     */
    public function __construct(CacheStorageInterface $cacheStorage, EventRepositoryInterface $eventRepository)
    {
        $this->cacheStorage = $cacheStorage;
        $this->eventRepository = $eventRepository;
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
        return $this->eventRepository->getCountEventsInRange($frame->getStartDate(), $frame->getEndDate());
    }
}