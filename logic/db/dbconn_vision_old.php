<?php

class Connection
{
        private static $instance = null; // For Singleton Pattern
        private $conn;
        private $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];

        private function __construct()
        {
                // Retrieve database credentials from environment variables
                $server = getenv('DB_SERVER') ?? "sqlsrv:server=PUTSVISP01; database=V7_VISION";
                $username = getenv('DB_USERNAME') ?? "wwal21";
                $password = getenv('DB_PASSWORD') ?? "Lady!104Misty!104";

                try {
                        $this->conn = new PDO($server, $username, $password, $this->options);
                }
                catch (PDOException $e) {
                        throw new Exception("ERROR! Problem with Database Connection: " . $e->getMessage());
                }
        }

        public static function getInstance()
        {
                if (self::$instance === null) {
                        self::$instance = new self();
                }
                return self::$instance;
        }

        public function getConnection()
        {
                return $this->conn;
        }

        public function close()
        {
                $this->conn = null;
        }
}