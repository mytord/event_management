<?php

namespace App\DB;

/**
 * Class MysqlConnection.
 */
class MysqlConnection implements ConnectionInterface
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
     * {@inheritdoc}
     */
    public function execute(string $sql, array $parameters = [])
    {
        $this->connection->prepare($sql)->execute($parameters);
    }

    /**
     * {@inheritdoc}
     */
    public function fetchArray(string $sql, array $parameters = []): array
    {
        return $this->connection->prepare($sql)->fetchAll($parameters);
    }
}