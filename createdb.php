<?php

// load the credentials
require_once 'database.php';

query("
CREATE TABLE rooms (
  room_id       INTEGER AUTO_INCREMENT PRIMARY KEY, 
  room_name     VARCHAR(255) NOT NULL,
  room_number   INTEGER NOT NULL,
  capacity      INTEGER NOT NULL,
  has_dvd       TINYINT(1) NOT NULL,
  has_projector TINYINT(1) NOT NULL,
  has_computer  TINYINT(1) NOT NULL,
  has_phone     TINYINT(1) NOT NULL
)");

query("INSERT INTO rooms 
(room_name, room_number, capacity, 
 has_dvd, has_projector, has_computer, has_phone) 
VALUES 
('Tripp Room',   212, 50, TRUE, TRUE, TRUE, TRUE),
('Computer Lab', 208, 40, TRUE, TRUE, TRUE, FALSE),
('Study Room 8',   8,  8, FALSE, FALSE, TRUE, TRUE),
('Study Room 5',   5,  4, FALSE, FALSE, TRUE, FALSE)");

query("
CREATE TABLE contacts (
  contact_id   INTEGER AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(255) NOT NULL,
  phone VARCHAR(255) NOT NULL,
  email VARCHAR(255) NOT NULL,
  group_name VARCHAR(255)
)
");

query("
CREATE TABLE reservations (
  id                   INTEGER AUTO_INCREMENT PRIMARY KEY,
  contact_id           INTEGER NOT NULL REFERENCES contacts(contact_id),
  start                DATETIME NOT NULL,
  stop                 DATETIME NOT NULL,
  repeat_style         ENUM('none','daily','weekdays','mwf','tr','weekly','monthly') NOT NULL,
  repeat_day           ENUM('m','w','t','w','r','f','s','u'),
  repeat_until         DATETIME,
  number_of_attendees  ENUM('small','medium','large','xlarge') NOT NULL,
  room_id              INTEGER REFERENCES rooms(room_id),
  instructions         TEXT,
  is_nmt               TINYINT(1) NOT NULL,
  is_federal           TINYINT(1) NOT NULL,
  is_state             TINYINT(1) NOT NULL,
  needs_dvd            TINYINT(1) NOT NULL,
  needs_computer       TINYINT(1) NOT NULL,
  needs_projector      TINYINT(1) NOT NULL,
  needs_phone          TINYINT(1) NOT NULL,
  signed               TINYINT(1) NOT NULL
)
");

?>
