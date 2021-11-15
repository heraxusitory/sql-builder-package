<?php


namespace sql;


interface SQLBuilder
{
    public function select();
    public function limit();
    public function where();
    public function first();
    public function find();

    public function get();

    public function offset();
    public function groupBy();
    public function delete();
    

}