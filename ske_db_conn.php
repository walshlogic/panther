<?php
require './logic/dbconn.php';
// $start and $display essential for pagination
$database = new Connection();
$db = $database->open();
$query = "SELECT * FROM vis_plus_index ORDER BY rem_acct_num ASC";
$res = mysqli_query($db, $query);
try {
    $sql = 'SELECT * FROM vis_plus_index ORDER BY rem_acct_num ASC';
    foreach ($db->query($sql) as $row) {
        ?>
                <?php echo $row['REM_PID'] ?>
                <?php echo $row['REM_ACCT_NUM'] ?>
                <?php echo $row['REM_OWN_NAME'] ?>
                <?php
                if ($row['REM_PRCL_LOCN'] == '00 Unassigned Location RE') {
                    echo '<i style="color:silver">>> NO ASSIGNED ADDRESS <<</i>';
                } else {
                    echo $row['REM_PRCL_LOCN'];
                }
                ?>
                <?php echo $row['REM_PRCL_LOCN_CITY'] ?>
                <?php
    }
}
catch (PDOException $e) {
    echo "ERROR! Problem with Database Connection (PANTHER Error #DB100): " . $e->getMessage();
}
// close database connection
$database->close();