<?php

namespace App\EventRegistry;

use App\EventInterface;

/**
 * Abstraction around MQ engine (Gaerman, RabbitMQ).
 */
interface EventRegistryInterface
{
    /**
     * @param EventInterface $event
     */
    public function registerEvent(EventInterface $event);
}