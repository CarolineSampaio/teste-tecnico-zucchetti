<?php

class Database
{
    private $connection;

    public function __construct()
    {
        $host = getenv('DB_HOST');
        $port = getenv('DB_PORT');
        $dbname = getenv('DB_NAME');
        $username = getenv('DB_USER');
        $password = getenv('DB_PASS');
        $this->connection = new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $username, $password);
    }

    public function getConnection()
    {
        return $this->connection;
    }
}
