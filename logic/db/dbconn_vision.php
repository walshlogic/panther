<?php
// dbconn_vision.php //
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
        // Load settings from XML
        $xml = simplexml_load_file("./logic/settings.xml");

        $server = (string) $xml->VisionDatabaseServer;
        $database = (string) $xml->VisionDatabase;
        $user = (string) $xml->VisionUser;
        $password = (string) $xml->VisionPassword;

        $connectionString = "dblib:host=$server;database=$database";

        try {
            $this->conn = new PDO($connectionString, $user, $password, $this->options);
        }
        catch (PDOException | Exception $e) {
            $this->conn = null;
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