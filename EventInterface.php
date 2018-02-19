<?php

namespace App;

/**
 * Interface for Event model.
 */
interface EventInterface
{
    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @return string
     */
    public function getDescription(): string;
}