<?php
require 'calendarsetup.php';

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

    mail('nmtlib@gmail.com',
        'Test Message',
        $body,
        $headers);
}

/**
 * Creates an entry on the Google calendar for the patron's event.
 */
function create_google_calendar_entry() {
    // Get the API client and construct the service object.
    $client = getClient();
    $service = new Google_Service_Calendar($client);
    //change this to the correct address of the calendar you wish you change
    //it is found in calendar settings under "calendar Address" 
    $ID = 'u3i2i3mp5o9ljihednbh29cas4@group.calendar.google.com';

    $event = new Google_Service_Calendar_Event();
    $startTime = new Google_Service_Calendar_EventDateTime();
    $startTime->setDateTime(date('c', strtotime($_POST['rezdate'] ." ". $_POST['arr_time'])));
    $startTime->setTimeZone("America/Denver");
    $endTime = new Google_Service_Calendar_EventDateTime();
    $endTime->setDateTime(date('c', strtotime($_POST['rezdate'] ." ". $_POST['dep_time'])));
    $endTime->setTimeZone("America/Denver");
    $event->setStart($startTime);
    $event->setEnd($endTime);
    $event->setSummary("Skeen Library Meeting Space Reservation");
    $event->setDescription("
        Attendees: ". $_POST['numberofattendees'] ."\n
        NMT Affiliation: ". $_POST['tech'] ."\n
        Federal Affiliation: ". $_POST['federal'] ."\n
        State Affiliation: ". $_POST['state'] ."\n\n
        
        Equipment Requirments:\n
        DVD: ". $_POST['needsdvd'] ."\n
        Computer: ". $_POST['needscomputer'] ."\n
        Projector: ". $_POST['needsprojector'] ."\n
        Phone: ". $_POST['needsphone'] ."\n\n
        
        Special Instructions: \n". $_POST['instructions'] ."\n
        
        
    ");
    $event->setLocation($_POST['room']);
    $event->setAttendees(25);
    $event->setKind("meeting");
    $service->events->insert($ID, $event);
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

echo "<h4>Thank you for your submission!</h4>";
echo "<h5>Redirecting you back to the home page!</h5>";