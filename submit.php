<?php

// This script basically performs three steps:
//
// 1. Validate the room reservation
// 2. Record the room reservation in our database
// 3. Send the user a confirmation email (and copy it to the desk).
//
// That's really all we have to do, so let's dig in.

// Step 1. Validation
// This is a rehash of the form validation we do in Javascript
if ($_POST['commercial'] == 'on') {
    http_response_code(400); // "Bad Request"
    die("Sorry, you must not use the library for commercial activity; 
         we cannot accept your room reservation.");
}
else if (!isset($_POST['agree']) || $_POST['agree'] != 'on') {
    http_response_code(400); // "Bad Request"
    die("Sorry, you must accept the terms of the agreement to reserve a room.");
}

// If we make it here, validation succeeded.
// Step 2. Record the room reservation
getOne("INSERT INTO contacts (name, phone, email, group_name) VALUES (?, ?, ?, ?)",
    array($_POST['name'], $_POST['phone'], $_POST['email'], $_POST['group name']));
$contact_id = getOne("SELECT LAST_INSERT_ID()");

query("INSERT INTO reservations 
(contact_id, start, stop, repeat_style, repeat_day, repeat_until, number_of_attendees,
 room_id, instructions, is_nmt, is_federal, is_state, 
 needs_dvd, needs_computer, needs_projector, needs_phone, signed) 
VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
array($contact_id,
    $_POST['rezdate'] ." ". $_POST['arr_time'],
    $_POST['rezdate'] ." ". $_POST['dep_time'],
    $_POST['repeats'],
    implode($_POST['days']),
    $_POST['until'],
    $_POST['numberofattendees'],
    $_POST['room'],
    $_POST['instructions'],
    $_POST['tech'],
    $_POST['federal'],
    $_POST['state'],
    $_POST['needsdvd'],
    $_POST['needscomputer'],
    $_POST['needsprojector'],
    $_POST['needsphone'],
    $_POST['agree']));

// Step 3. Send the confirmation email and copy to desk
mail('fusion@storytotell.org', 'Test Message', 'This is a test message');

?>