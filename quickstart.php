
<?php
require 'calendarsetup.php';

if (php_sapi_name() != 'cli') {
    throw new Exception('This application must be run on the command line.');
}

// Get the API client and construct the service object.
$client = getClient();
$service = new Google_Service_Calendar($client);

// Print the next 10 events on the user's calendar.
$calendarId = 'primary';
$optParams = array(
    'maxResults' => 10,
    'orderBy' => 'startTime',
    'singleEvents' => TRUE,
    'timeMin' => date('c'),
);
$results = $service->events->listEvents($calendarId, $optParams);

if (count($results->getItems()) == 0) {
    print "No upcoming events found.\n";
} else {
    print "Upcoming events:\n";
    foreach ($results->getItems() as $event) {
        $start = $event->start->dateTime;
        if (empty($start)) {
            $start = $event->start->date;
        }
        printf("%s (%s)\n", $event->getSummary(), $start);
    }
}

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
$service->events->insert('primary', $event);
