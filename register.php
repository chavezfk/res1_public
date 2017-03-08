<?php

require_once __DIR__ . '/vendor/autoload.php';

date_default_timezone_set("MST7MDT");

define('APPLICATION_NAME', 'nmt-library-room-calendar-service');
define('CREDENTIALS_PATH', '~/.credentials/calendar-php-quickstart.json');
define('CLIENT_SECRET_PATH', __DIR__ . '/client_secret.json');
// If modifying these scopes, delete your previously saved credentials
// at ~/.credentials/calendar-php-quickstart.json
define('SCOPES', implode(' ', array(
        Google_Service_Calendar::CALENDAR)
));

function read_template($filename) {
    ob_start();
    include $filename;
    return ob_get_clean();
}

/**
 * Sends the actual email to the patron, confirming their submission.
 */
function send_email_to_patron() {
    $headers = "";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

    $body = read_template("patron_email_body.php");

    mail($_POST['email'],
        'Skeen Library Room Reservation',
        $body,
        $headers);
}

/**
 * Sends an email about the reservation request to the circulation desk.
 */
function send_email_to_circulation() {
    $headers = "";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

    $body = read_template("circulation_email_body.php");

    mail('chavezfk@gmail.com',
        'Test Message',
        $body,
        $headers);
}

/**
 * Creates an entry on the Google calendar for the patron's event.
 */
function create_google_calendar_entry() {
    $event = new Google_Service_Calendar_Event();
	$startTime = new Google_Service_Calendar_EventDateTime();
	$startTime->setDateTime(date('c', strtotime("tomorrow 3pm")));
	$startTime->setTimeZone("America/Denver");
	$endTime = new Google_Service_Calendar_EventDateTime();
	$endTime->setDateTime(date('c', strtotime("tomorrow 3:30pm")));
	$endTime->setTimeZone("America/Denver");
	$event->setStart($startTime);
	$event->setEnd($endTime);
	$event->setSummary("Meet with the Pope");
	$event->setDescription("Roses are red\nViolets are blue\nI can't rhyme\nAnd neither can you");
	$event->setLocation("Tripp room");
	$event->setAttendees(25);
	$event->setKind("meeting");
	$service->events->insert('pending', $event);
}

/**
 * Validates the form submission, returning 'true' if
 * the submission is valid and the request can be saved.
 *
 * @return bool whether or not the patron's submission is acceptable
 */
function validate_submission() {
    // FIXME: Don't trust the user's Javascript so much
    // We probably shouldn't trust that the Javascript
    // prevented the user from doing anything they
    // should not have been able to do here, but right now
    // that's what we do.
    return true;
}

/**
 * Explains to the patron why their submission is not valid.
 */
function complain_loudly_to_the_patron() {

}

/*****************************************************************************/
/*                                                                           */
/*         T H E    A C T U A L   S U B M I S S I O N   H A N D L E R        */
/*                                                                           */
/*****************************************************************************/
function handle_submission() {
    // if the submission is valid, keep it
    if (validate_submission()) {
        // first make the google calendar entry
        create_google_calendar_entry();

        // then email circulation
        send_email_to_circulation();

        // then email the patron
        send_email_to_patron();
    }

    // if the submission is not valid
    else {
        // tell the patron why
        complain_loudly_to_the_patron();
    }
}

// handle the user's submission
handle_submission();

echo "Thank you for your submission!";
echo "<table>";
foreach ($_POST as $value){
    echo "<tr><td>";
    echo $value;
    echo "</td><td>";
    echo $value;
    echo "</td></tr>";
}
echo "</table>";