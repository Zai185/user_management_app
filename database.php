<?php
const DB_HOST =  "localhost";
const DB_USER =  "root";
const DB_PASSWORD =  "";
const DB_DATABASE=  "user_management";

function db(){
    static $pdo;

    if(!$pdo){
        $pdo = new PDO(
            sprintf("mysql:host=%s;dbname=%s;charset=UTF8",DB_HOST, DB_DATABASE),
            DB_USER,
            DB_PASSWORD,
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
    }

    return $pdo;
}

$pdo = db();
