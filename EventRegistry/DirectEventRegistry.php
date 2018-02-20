<?php

namespace App\EventRegistry;

use App\EventInterface;
use App\EventRegistry\Handler\CreateEventHandler;

/**
 * Simple registry (without queues)
 */
class DirectEventRegistry implements EventRegistryInterface
{
    /**
     * @var CreateEventHandler
     */
    private $handler;

    /**
     * DirectEventRegistry constructor.
     * @param CreateEventHandler $handler
     */
    public function __construct(CreateEventHandler $handler)
    {
        $this->handler = $handler;
    }

    /**
     * {@inheritdoc}
     */
    public function registerEvent(EventInterface $event)
    {
        $this->handler->handle($event);
    }
}