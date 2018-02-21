<?php

namespace App\Repository;

use App\EventInterface;

/**
 * Abstraction around db event storage
 */
interface EventRepositoryInterface
{
    /**
     * @param EventInterface $event
     */
    public function add(EventInterface $event);

    /**
     * @param \DateTimeInterface $startDate
     * @param \DateTimeInterface $endDate
     *
     * @return int
     */
    public function getCountEventsInRange(\DateTimeInterface $startDate, \DateTimeInterface $endDate): int;
}