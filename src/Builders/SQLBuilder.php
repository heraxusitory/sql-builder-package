<?php

namespace sql\Builders;

interface SQLBuilder
{
    public function select($table, $fields);
    public function limit(int $start, int $offset);
    public function where($field, $operator, $value);
    public function first();
    public function find($id);

    public function get();

    public function offset($start);
    public function groupBy();
    public function delete();
    

}