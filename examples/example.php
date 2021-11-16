<?php

use SQL\Builder\Builders\MySQLBuilder;

require_once '../vendor/autoload.php';

function printCust($data) {
     echo '<pre>';
     var_dump($data);
     echo '</pre>';
};

/*init MySQL Builder*/
$builder = new MySQLBuilder();

/*Example 1*/
/*Build query select*/
$record = $builder->select('users', 'first_name, last_name, email, phone')
    /*Build query where*/
    ->where('first_name', '=', 'Иван')
    /*Getting first record*/
    ->first();

printCust($record);
printCust(($record));

/*Example 2*/
echo 1;
$record = $builder->select('users', '*')
    ->where('id', '>', 1)
    ->get();

printCust($record);

/*Example 3*/
$builder->select('users', '*')
    ->where('id', '<', 100)
    ->limit('5');

/*Example 4*/
$builder->select('users', '*')
    ->find(1);

/*Example 5*/
$builder->table('users')->first();

/*Example 6*/
//$builder->table('users')
//    ->where('id', '<', 100)
//    ->delete();

/*Example 7*/
$builder->table('users')->get();

/*Example 8*/
$record = $builder->table('users')->update(['first_name' => 'Ivanov']);
printCust($record);