<?php

class Connection
{

    private
    $server = "mysql:host=localhost;dbname=panther";
    private
    $username = "root";
    private
    $password = "Lady!104Misty!104";
    private
    $options = array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, );

    protected $conn;

    public
        function open(
    ) {
        try {
            $this->conn = new PDO($this->server, $this->username, $this->password, $this->options);
            return $this->conn;
        }
        catch (PDOException $e) {
            echo "ERROR! Problem with Database Connection (PANTHER Error #DB101): " . $e->getMessage();
        }
    }

    public
        function close(
    ) {
        $this->conn = null;
    }

}