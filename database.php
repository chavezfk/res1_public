<?php

// these are the MySQL database credentials we use
// please set them to wherever the database may be found

$DB_HOST     = "localhost";
$DB_USER     = "skeen";
$DB_PASSWORD = "skeen";
$DB_NAME     = "skeen";
$DB_STR      = "mysql:host=$DB_HOST;dbname=$DB_NAME;";

require_once 'dbpdo.php';

$D1 = new PDO($DB_STR, $DB_USER, $DB_PASSWORD);
$DB = new PDO2DB($D1);

?>