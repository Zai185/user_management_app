<?php

class Model{
    public static function __callStatic($method, $args){
        return (new static)->$method(...$args);
    }

    public function __call($method, $args)
    {
        return $this->query()->$method(...$args);
    }


    public function query()
    {
        return new QueryBuilder(DBConnection::run(require 'config/database.php')); 
    }

    public function hello(){
        echo "say hello";
    }

}