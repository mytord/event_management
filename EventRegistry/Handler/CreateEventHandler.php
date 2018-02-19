<?php

namespace App\EventRegistry\Handler;

use App\Analytic\EventCountAggregator;
use App\DB\ConnectionInterface;
use App\EventInterface;
use App\TimeFrame;

/**
 * Simple worker/consumer.
 */
final class CreateEventHandler
{
    /**
     * @var ConnectionInterface
     */
    private $connection;

    /**
     * @var EventCountAggregator
     */
    private $aggregator;

    /**
     * CreateEventHandler constructor.
     * @param ConnectionInterface $connection
     * @param EventCountAggregator $aggregator
     */
    public function __construct(ConnectionInterface $connection, EventCountAggregator $aggregator)
    {
        $this->connection = $connection;
        $this->aggregator = $aggregator;
    }

    /**
     * @param EventInterface $event
     *
     * @return bool
     */
    public function handle(EventInterface $event): bool
    {
        try {
            $sql = 'INSERT INTO events (event_name, description, created_at) VALUES (?, ?, NOW())';

            $this->connection->execute($sql, [
                $event->getName(),
                $event->getDescription(),
            ]);
        } catch (\Exception $exception) {
            return false;
        }

        $this->aggregator->incrementValue(TimeFrame::lastMinute());
        $this->aggregator->incrementValue(TimeFrame::lastHour());
        $this->aggregator->incrementValue(TimeFrame::lastDay());

        return true;
    }
}