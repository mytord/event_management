<?php

namespace App\Repository;

use App\EventInterface;

/**
 * Class SimpleRepository.
 */
class SimpleRepository implements EventRepositoryInterface
{
    /**
     * @var \PDO
     */
    private $connection;

    /**
     * MysqlConnection constructor.
     *
     * @param string $host
     * @param string $db
     * @param string $user
     * @param string $password
     */
    public function __construct(string $host, string $db, string $user, string $password)
    {
        $this->connection = new \PDO("mysql:host=$host;dbname=$db", $user, $password);
    }

    /**
     * @inheritDoc
     */
    public function add(EventInterface $event)
    {
        $this
            ->connection
            ->prepare('INSERT INTO events (event_name, description, created_at) VALUES (?, ?, NOW())')
            ->execute([
                $event->getName(),
                $event->getDescription(),
            ]);
    }

    /**
     * @inheritDoc
     */
    public function getCountEventsInRange(\DateTimeInterface $startDate, \DateTimeInterface $endDate): int
    {
        $statement = $this->connection->prepare('SELECT COUNT(*) FROM events WHERE created_at BETWEEN ? AND ?');
        $statement->bindParam(1, $startDate->format('Y-m-d H:i:s'));
        $statement->bindParam(2, $endDate->format('Y-m-d H:i:s'));

        return (int) $statement->fetchColumn(0);
    }
}