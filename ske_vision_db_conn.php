<?php
$serverName = "slqsrv:server=PUTSVISP01";
$databaseName = "V7_VISION";
$username = "PUTNAM-FL\wwal21";
$password = "Dixie!104Gizmo!104";
try {
    // Connect to the database using PDO
    $conn = new PDO(
        "mysql:host=$serverName;dbname=$databaseName",
        $username,
        $password
    );
    // Set error handling to exception mode
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // Perform SQL queries
    $sql = "SELECT * FROM your_table";
    $stmt = $conn->query($sql);
    // Fetch data
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    // Process the result
    foreach ($result as $row) {
        // Do something with each row of data
        //echo "Column1: " . $row['column1'] . ", Column2: " . $row['column2'] . "<br>";
    }
}
catch (PDOException $e) {
    //echo "Connection failed: " . $e->getMessage();
}
?>