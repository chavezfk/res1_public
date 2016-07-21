<?php

// load the credentials
require_once 'database.php';

query("
CREATE TABLE rooms (
  id            INTEGER AUTO_INCREMENT PRIMARY KEY, 
  room_name     VARCHAR(255),
  room_number   INTEGER,
  capacity      INTEGER,
  has_dvd       TINYINT(1),
  has_projector TINYINT(1),
  has_computer  TINYINT(1),
  has_phone     TINYINT(1)
)");

query("
CREATE TABLE reservations (
  id          INTEGER AUTO_INCREMENT PRIMARY KEY,
  start       DATETIME,
  stop        DATETIME,
  
)
")


?>
