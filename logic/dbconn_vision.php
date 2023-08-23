<?php

class Connection
{
        private $server;
        private $username;
        private $password;
        private $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];
        protected $conn;

        public function __construct()
        {
                // Retrieve database credentials
                $this->server = getenv('DB_SERVER') ?: "sqlsrv:server=PUTSVISP01; database=V7_VISION";
                $this->username = getenv('DB_USERNAME') ?:
                        //"PUTNAM-FL\wwal21";
                        "wwal21";
                $this->password = getenv('DB_PASSWORD') ?: "Dixie!104Gizmo!104";
        }

        public function open()
        {
                try {
                        $this->conn = new PDO($this->server, $this->username, $this->password, $this->options);
                        return $this->conn;
                }
                catch (PDOException $e) {
                        // Log the error instead of echoing
                        error_log("ERROR! Problem with Database Connection (PANTHER Error #DB101): " . $e->getMessage());
                }
        }

        public function close()
        {
                $this->conn = null;
        }
}