<?php


namespace sql\DB;


use PDO;

class DBConnection
{
    private static $connection;

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    public static function getInstance(string $db_connect_name): PDO
    {
        if (!self::$connection)
            try {
                self::$connection = new PDO('mysql' . ':host=localhost;dbname=test_database;charset=utf8', 'root', 'root');;
            } catch (\PDOException $e) {
                echo 'Не удалось создать подключение к базе данных.';
                die();
            }
        return self::$connection;
    }
}