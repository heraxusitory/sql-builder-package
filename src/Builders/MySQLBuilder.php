<?php


namespace sql\Builders;


use sql\DB\DBConnection;
use sql\DB\MySQLConnection;
use sql\SQLBuilder;

class MySQLBuilder implements SQLBuilder
{
    private ?MySQLConnection $connection;
    private $query = null;

    public function __construct()
    {
        $this->connection = new MySQLConnection();
    }

    public function select()
    {
        // TODO: Implement select() method.
    }

    public function where()
    {
        // TODO: Implement where() method.
    }

    public function limit()
    {
        // TODO: Implement limit() method.
    }

    public function first()
    {
        // TODO: Implement first() method.
    }

    public function get()
    {
        // TODO: Implement get() method.
    }

    public function groupBy()
    {
        // TODO: Implement groupBy() method.
    }

    public function find()
    {
        // TODO: Implement find() method.
    }

    public function offset()
    {
        // TODO: Implement offset() method.
    }

    public function delete()
    {
        // TODO: Implement delete() method.
    }
}