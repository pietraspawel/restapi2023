<?php

namespace pietras\RestApi;

class Database extends \PDO
{
    private const OPTIONS = [
        \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
    ];

    public function __construct(string $host, string $user, string $pass, string $databaseName, int $port)
    {
        $dsn = "mysql:host={$host};dbname={$databaseName};port={$port}";

        try {
            parent::__construct($dsn, $user, $pass, self::OPTIONS);
        } catch (PDOException $exception) {
            throw new PDOException($exception->getMessage(), (int) $exception->getCode());
        }
    }
}
