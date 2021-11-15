<?php


namespace sql\Builders;


use sql\DB\MySQLConnection;

class MySQLBuilder implements SQLBuilder
{
    private $query = null;
    private $wheres = [];
    private $table_name = null;

    public function __construct()
    {
    }

    public function toSql()
    {
        return $this->query;
    }

    private function reset()
    {
        $this->query = new \stdClass();
        printCust($this->query->base);
        $this->wheres = [];
        $this->table_name = null;
    }

    public function select($table, $fields)
    {
        $this->reset();
        $this->query->base = "SELECT {$fields} FROM {$table}";
        printCust($this->query->base);
        $this->query->type = 'select';

        return $this;
    }

    public function where($field, $operator, $value)
    {
        if (!in_array($this->query->type, ['select', 'update', 'delete', 'table']))
            throw new \Exception('WHERE can only be added to SELECT, UPDATE OR DELETE');

        $this->wheres[] = " $field " . " $operator " . " $value ";
//        $this->query->base .= " WHERE {$field} $operator '{$value}'";
        printCust($this->query->base);

        return $this;
    }

    public function limit($start, $offset = 0)
    {
        $this->query->base .= " LIMIT {$start}" . ($offset ? " OFFSET $offset " : '');
        printCust($this->query->base);

        return $this;
    }

    public function first()
    {
        if (!in_array($this->query->type, ['select', 'table']))
            throw new \Exception('FIRST can only be added to SELECT');
        if ($this->query->type === 'table')
            $this->query->base = "SELECT * FROM {$this->table_name }";
        $this->query->base .= $this->addWheres();
        $this->limit(1);
//        $this->query->base .= " LIMIT 1";
        printCust($this->query->base);
        return $this->execute();
    }

    public function get()
    {
        if (!in_array($this->query->type, ['select', 'table']))
            throw new \Exception('GET can only be added to SELECT');
        if ($this->query->type === 'table')
            $this->query->base = 'SELECT * from ' . $this->table_name . $this->addWheres();

        $this->query->base .= $this->addWheres();
        printCust($this->query->base);
        return $this->execute();
    }

    public function groupBy()
    {
        // TODO: Implement groupBy() method.
    }

    public function find($id)
    {
        if (!in_array($this->query->type, ['select', 'table']))
            throw new \Exception('FIND can only be added to SELECT');

        if ($this->query->type === 'table')
            $this->query->base = "SELECT * FROM {$this->table_name}";
        $this->query->base .= " WHERE id='{$id}'";
        printCust($this->query->base);

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
        $this->query->base = "DELETE FROM {$this->table_name} ";
        foreach ($this->wheres as $where)
            $this->query->base .= $where;
        printCust($this->query->base);

        return $this->execute();
    }

    private function execute()
    {
        printCust($this->query->base);

        return (new MySQLConnection())->execute($this->query->base);
    }

    private function addWheres()
    {
        $query = '';
        for ($i = 0; count($this->wheres) > $i; $i++) {
            if (!$i)
                $query .= ' WHERE ' . $this->wheres[$i];
            else
                $query .= ' AND ' . $this->wheres[$i];
        }

        return $query;
    }

    private function setUpdateValues(array $updates)
    {
        $query = '';
        foreach ($updates as $k => $v)
            $query .= $k . '=' . "'$v'";

        if (!empty($query))
            $query = 'SET '. $query;
        return $query;
    }

    public function update(array $values) {
        if (!in_array($this->query->type, ['table']))
            throw new \Exception('Syntax error when trying to update a record(s)');
        $this->query->base = "UPDATE {$this->table_name} ";
        $this->query->base .= $this->setUpdateValues($values);
        $this->query->base .= $this->addWheres();
        printCust($this->query->base);

        return $this->execute();
    }
}