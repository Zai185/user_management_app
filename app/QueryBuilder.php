<?php

class QueryBuilder
{
    public PDO $pdo;
    public $query;
    public function __construct(PDO $pdo)
    {
        $this->query = "";
        $this->pdo = $pdo;
    }

    public function get($table)
    {
        $sql = "select * from $table " . $this->query;
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
    public function all($table)
    {
        $sql = "select * from $table ";
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function where($column, $value)
    {
        $this->query .= "where $column = $value ";
        return $this;
    }

    public function create($table, $data)
    {

        $columns = implode(',', array_keys($data));
        $values = array_values($data);
        $markedValues = implode(',', array_fill(0, count($values), "?"));
        $sql = "insert into $table ($columns) values ($markedValues)";
        $this->pdo->prepare($sql)->execute($values);
    }



    public function run(){
        echo "running";
    }
    
}
