<?php


namespace sql\DB;


class MySQLConnection
{
    private $connection = null;
    private const DB_CONNECTION_NAME = 'mysql';

    public function __construct()
    {
        $this->connection = DBConnection::getInstance(self::DB_CONNECTION_NAME);

        return $this;
    }

    public function close()
    {
        if ($this->connection)
            $this->connection = null;
    }

    public function execute($query)
    {
        var_dump($query);
        $stm = $this->connection->prepare($query);
        $stm->execute();
        $this->close();
        return $stm->fetchAll();
    }
}