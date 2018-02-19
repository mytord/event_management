<?php

namespace App\DB;

/**
 * Abstraction around DB connection (PDO or Doctrine ORM).
 */
interface ConnectionInterface
{
    /**
     * @param string $sql
     * @param array $parameters
     */
    public function execute(string $sql, array $parameters = []);

    /**
     * @param string $sql
     * @param array $parameters
     *
     * @return array
     */
    public function fetchArray(string $sql, array $parameters = []): array;
}