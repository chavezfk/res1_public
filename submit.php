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
else if (!isset($_POST['agree']) && $_POST['agree'] == 'on') {
    http_response_code(400); // "Bad Request"
    die("Sorry, you must accept the terms of the agreement to reserve a room.");
}

// If we make it here, validation succeeded.
// Step 2. Record the room reservation


// Step 3. Send the confirmation email and copy to desk
mail('fusion@storytotell.org', 'Test Message', 'This is a test message');

?>