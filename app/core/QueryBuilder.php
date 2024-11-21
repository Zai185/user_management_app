<?php

class QueryBuilder
{
    public PDO $pdo;
    protected static $connection = DBConnection::class;
    public $query;
    public $table;
    public $select;
    private $hasWhere = false;
    public function __construct($table)
    {

        $this->select = "*";
        $this->query = '';
        $this->table = $table;
        $this->pdo = $this->getConnection();
    }


    public function first()
    {
        $sql = "select {$this->select} from {$this->table} {$this->query}";
        return $this->pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
    }
    public function get()
    {
        $sql = "select {$this->select} from {$this->table} {$this->query}";
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
    public function all()
    {
        $sql = "select {$this->select} from {$this->table} ";
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function where($column, $value): static
    {
        if (!$this->hasWhere) {
            $this->query .= " where";
            $this->hasWhere = true;
        } else {
            $this->query = " and ";
        }
        $this->query .= " $this->table.$column = '$value'";
        return $this;
    }


    public function join($s_table, $column, $s_column, $join_type = ''): static
    {

        $this->query = " $join_type join $s_table on {$this->table}.$column = $s_table.$s_column" . $this->query;
        return $this;
    }
    public function joinWhere($s_table, $column, $s_column, $value, $join_type = '')
    {

        $sql = "select * from {$this->table} $join_type join $s_table on {$this->table}.$s_column = $s_table.$s_column where $column = '$value'";
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }

    public function select(...$columnArr)
    {
        $this->select  = implode(",", $columnArr);
        return $this;
    }

    public function create($data)
    {
        $columns = implode(',', array_keys($data));
        $values = array_values($data);
        $markedValues = implode(',', array_fill(0, count($values), "?"));
        $sql = "insert into {$this->table} ($columns) values ($markedValues)";
        $this->pdo->prepare($sql)->execute($values);
        $id = $this->pdo->lastInsertId();
        return $id
            ? $this->find($id)
            : true;
    }

    public function update($data)
    {
        //* UPDATE users SET name = 'John Doe', email = 'john@example.com' WHERE id = 1;

        $columns = array_keys($data);
        $values = array_values($data);
        $sql_update = '';
        for ($i = 0; $i < count($data); $i++) {
            $sql_update .= "{$columns[$i]} = '{$values[$i]}'";
            if ($i !== count($data) - 1) {
                $sql_update .= ",";
            }
        }
        $sql = "UPDATE {$this->table} SET $sql_update WHERE id = {$data['id']}";
        return $this->pdo->exec($sql);
    }

    public function delete($value, $column = 'id')
    {
        $sql = "delete from {$this->table} where $column = ?";
        return $this->pdo->prepare($sql)->execute([$value]);
    }

    public function find($value, $column = 'id')
    {

        $sql = "select {$this->select} from {$this->table} where $column=?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$value]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getConnection()
    {
        return static::$connection::run(config('database'));
    }
}
