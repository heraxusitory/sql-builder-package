<?php


namespace sql\Builders;


use sql\DB\MySQLConnection;

class MySQLBuilder implements SQLBuilder
{
    private $query = null;
    private $table_name;

    public function __construct()
    {

    }

    public function getSql()
    {
        return $this->query;
    }

    public function reset()
    {
        $this->query = new \stdClass();
    }

    public function select($table, $fields)
    {
        $this->reset();
        $this->query->base = "SELECT {$fields} FROM {$table}";
        $this->query->type = 'select';
        return $this;
    }

    public function where($field, $operator, $value)
    {
        if (!in_array($this->query->type, ['select', 'update', 'delete', 'table']))
            throw new \Exception('WHERE can only be added to SELECT, UPDATE OR DELETE');

        $this->query->base .= " WHERE {$field} $operator '{$value}'";

        return $this;
    }

    public function limit($start, $offset = 0)
    {
        $this->query->base .= ' LIMIT ' . $start . ' OFFSET ' . $offset;

        return $this;
    }

    public function first()
    {
        if (!in_array($this->query->type, ['select']))
            throw new \Exception('FIRST can only be added to SELECT');
        $this->query->base .= " LIMIT 1";
        return $this->execute();
    }

    public function get()
    {
        if (!in_array($this->query->type, ['select']))
            throw new \Exception('GET can only be added to SELECT');
        return $this->execute();
    }

    public function groupBy()
    {
        // TODO: Implement groupBy() method.
    }

    public function find($id)
    {
        if (!in_array($this->query->type, ['select']))
            throw new \Exception('FIND can only be added to SELECT');
        $this->query->base .= " WHERE id='{$id}'";
        return $this->execute();
    }

    public function offset($start)
    {
        // TODO: Implement offset() method.
    }

    public function table($table)
    {
        $this->reset();
        $this->query->type = 'table';
        $this->table_name = $table;

        return $this;
    }

    public function delete()
    {
        if (!in_array($this->query->type, ['table']))
            throw new \Exception('Syntax error when trying to delete a record');
        $this->query->base = "DELETE FROM {$this->table_name} " . $this->query->base;
        return $this->execute();
    }

    public function execute()
    {
        return (new MySQLConnection())->execute($this->query->base);
    }
}