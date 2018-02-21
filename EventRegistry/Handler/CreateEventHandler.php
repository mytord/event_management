<?php

namespace App\EventRegistry\Handler;

use App\Aggregation\EventCountAggregator;
use App\DB\ConnectionInterface;
use App\EventInterface;
use App\Repository\EventRepositoryInterface;
use App\TimeFrame;

/**
 * Simple worker/consumer.
 */
final class CreateEventHandler
{
    /**
     * @var EventCountAggregator
     */
    private $aggregator;

    /**
     * @var EventRepositoryInterface
     */
    private $eventRepository;

    /**
     * CreateEventHandler constructor.
     * @param EventCountAggregator $aggregator
     * @param EventRepositoryInterface $eventRepository
     */
    public function __construct(EventCountAggregator $aggregator, EventRepositoryInterface $eventRepository)
    {
        $this->aggregator = $aggregator;
        $this->eventRepository = $eventRepository;
    }

    /**
     * @param EventInterface $event
     *
     * @return bool
     */
    public function handle(EventInterface $event): bool
    {
        try {
            $this->eventRepository->add($event);
        } catch (\Exception $exception) {
            return false;
        }

        $this->aggregator->incrementValue(TimeFrame::lastMinute());
        $this->aggregator->incrementValue(TimeFrame::lastHour());
        $this->aggregator->incrementValue(TimeFrame::lastDay());

        return true;
    }
}