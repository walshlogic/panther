<?php

require 'db_conn.php';

// Retrieve database credentials from environment variables
//$dsn = getenv("DB_DSN") ?: "mysql:host=localhost;dbname=panther;charset=utf8";
$dsn = getenv("DB_DSN") ?: "mysql:host=127.0.0.1;dbname=panther;charset=utf8";
$username = getenv("DB_USERNAME") ?: "root";
$password = getenv("DB_PASSWORD") ?: "";

try {
    // Create a new Database object and connect
    $database = new Database($dsn, $username, $password);
    $pdo = $database->connect(); // Ensure you are actually calling the connect() method
    if (!$pdo) {
        throw new Exception("Failed to connect to the database.");
    }
}
catch (Exception $e) {
    error_log($e->getMessage());
    die("Could not connect to the database. Exception: " . $e->getMessage());
}