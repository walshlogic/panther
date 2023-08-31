<?php
require './logic/dbconn_vision.php';
$sqlFind = 'SELECT `*` FROM `REAL_PROP.REALMAST`';
$result = mysqli_query($conn, $sqlFind);
$db = []; // create empty array
while ($row = mysqli_fetch_row($result)) {
    array_push($db, $row[0]);
}
// Check files
$files1 = scandir($directory, 1);
if ($files1 !== false) {
    foreach ($files1 as $i => $value) {
        if (in_array($value, $db)) {
            // File exists in both
        } else {
            // File doesn't exist in database
        }
    }
} else {
    echo 0;
}