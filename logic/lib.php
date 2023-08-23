<?php

use PANTHER\logic\dbconn_vision as db;

$dbStateVision = "production";
$dbNameVision = "V7_VISION";
$vDb = new putDBcontrol();
$vDb->dbState = $dbStateVision;
$vDb->dbName = $dbNameVision;
$errmsg = "Open db $vDb->dbName on $vDb->dbState failed";

if ($vDb->putDBopen()) {
    $errmsg = "database " . $vDb->dbName . " on " . $vDb->dbState . " opened";
} else {
    print "Database open failed for $dbNameVision on $dbStateVision<br>";
}

$dbStatePA = "production";
$dbNamePA = "V7_PA";
$paDb = new putDBcontrol();
$paDb->dbState = $dbStatePA;
$paDb->dbName = $dbNamePA;
$errmsg = "Open db $paDb->dbName on $paDb->dbState failed";
if ($pDb->putDBopen()) {
    $errmsg = "database " . $paDb->dbName . " on " . $paDb->dbState . " opened";
} else {
    print "Database open failed for $dbNamePA on $dbStatePA<br>";
}