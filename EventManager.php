<?php

namespace App;

use App\Analytic\EventCountAggregator;
use App\EventRegistry\EventRegistryInterface;

/**
 * Class EventManager.
 */
final class EventManager
{
    /**
     * @var EventCountAggregator
     */
    private $eventCountAggregator;

    /**
     * @var EventRegistryInterface
     */
    private $eventRegistry;

    /**
     * EventManager constructor.
     * @param EventCountAggregator $eventCountAggregator
     * @param EventRegistryInterface $eventBus
     */
    public function __construct(EventCountAggregator $eventCountAggregator, EventRegistryInterface $eventBus)
    {
        $this->eventCountAggregator = $eventCountAggregator;
        $this->eventRegistry = $eventBus;
    }

    /**
     * 1. Учесть событие.
     *
     * @param EventInterface $event
     */
    public function registerEvent(EventInterface $event): void
    {
        $this->eventRegistry->registerEvent($event);
    }

    /**
     * 2. Выдать число событий за последнюю минуту (60 секунд).
     *
     * @return int
     */
    public function getEventsCountForTheLastMinute(): int
    {
        return $this->eventCountAggregator->getValue(TimeFrame::lastMinute());
    }

    /**
     * 3. Выдать число событий за последний час (60 минут).
     *
     * @return int
     */
    public function getEventsCountForTheLastHour(): int
    {
        return $this->eventCountAggregator->getValue(TimeFrame::lastHour());
    }

    /**
     * 4. Выдать число событий за последние сутки (24 часа)
     *
     * @return int
     */
    public function getEventsCountForTheLastDay(): int
    {
        return $this->eventCountAggregator->getValue(TimeFrame::lastDay());
    }
}