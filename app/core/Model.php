<?php

class Model
{

    protected $table;
    protected static $builder = QueryBuilder::class;
    protected static $connection = DBConnection::class;

    public static function __callStatic($method, $args)
    {
        return (new static)->$method(...$args);
    }

    public function __call($method, $args)
    {
        return $this->query()->$method(...$args);
    }


    public function query()
    {
        return new static::$builder($this->table ?? static::class . 's');
    }
}
