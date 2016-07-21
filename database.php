<?php

// these are the MySQL database credentials we use
// please set them to wherever the database may be found

$DB_HOST     = 'localhost';
$DB_USER     = 'skeen';
$DB_PASSWORD = 'skeen';
$DB_NAME     = 'skeen';

require_once 'dbpdo.php';

$DB = new PDO2DB(new PDO("mysql:host=$DB_HOST;dbname=$DB_NAME", $DB_USER, $DB_PASS));

?>