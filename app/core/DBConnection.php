<?php

class DBConnection
{
    public static $pdo;
    public static function run($connection)
    {   

        if (!static::$pdo) {

            return new PDO(
                sprintf("mysql:host=%s;dbname=%s;charset=UTF8", $connection['host'], $connection['database']),
                $connection['user'],
                $connection['password'],
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
        }
    }
}
