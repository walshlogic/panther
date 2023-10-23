<?php

class Database
{
    private $dsn;
    private $username;
    private $password;
    private $pdo;

    public function __construct($dsn, $username, $password)
    {
        $this->dsn = $dsn;
        $this->username = $username;
        $this->password = $password;
    }
    public function connect()
    {
        if ($this->pdo === null) {
            try {
                $this->pdo = new PDO($this->dsn, $this->username, $this->password);
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            catch (PDOException $e) {
                //error_log("Database Connection Error: " . $e->getMessage());
                //die("Database Connection Error: " . $e->getMessage()); // Display the error
            }
        }
        return $this->pdo;
    }


    public function tableExists($table)
    {
        try {
            $result = $this->pdo->query("SHOW TABLES LIKE " . $this->pdo->quote($table));
            return $result->rowCount() > 0;
        }
        catch (PDOException $e) {
            throw $e;
        }
    }

    public function disconnect()
    {
        $this->pdo = null;
        return true;
    }

    public function select($table, $columns = '*', $where = null, $order = null)
    {
        $sql = "SELECT $columns FROM $table";
        if ($where) {
            $sql .= " WHERE $where";
        }
        if ($order) {
            $sql .= " ORDER BY $order";
        }

        if ($this->tableExists($table)) {
            $stmt = $this->pdo->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        return false;
    }

    public function insert($table, $data)
    {
        if ($this->tableExists($table)) {
            $columns = implode(", ", array_keys($data));
            $values = ":" . implode(", :", array_keys($data));
            $sql = "INSERT INTO $table ($columns) VALUES ($values)";

            $stmt = $this->pdo->prepare($sql);

            foreach ($data as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }

            return $stmt->execute();
        }
        return false;
    }

    public function delete($table, $where = null)
    {
        if ($this->tableExists($table)) {
            $sql = "DELETE FROM $table";
            if ($where) {
                $sql .= " WHERE $where";
            }

            return $this->pdo->exec($sql) > 0;
        }
        return false;
    }

    public function update($table, $data, $where)
    {
        if ($this->tableExists($table)) {
            $fields = '';
            foreach ($data as $column => $value) {
                $fields .= "$column = :$column, ";
            }
            $fields = rtrim($fields, ', ');

            $sql = "UPDATE $table SET $fields WHERE $where";

            $stmt = $this->pdo->prepare($sql);

            foreach ($data as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }

            return $stmt->execute();
        }
        return false;
    }
}