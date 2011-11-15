<?php

$string['enrolname'] = 'Cvent';
$string['server_settings'] = 'Cvent Settings';
$string['description'] = "You can use Cvent (cvent.com) to manage your enrolments. (You must be a customer of Cvent and have API access in order to use this plugin.)";
$string['enrol_cvent_account_number'] = "Your Cvent account ID. (You must receive this value from Cvent.)";
$string['enrol_cvent_username'] = "Your Cvent account username. (You must receive this value from Cvent.)";
$string['enrol_cvent_password'] = "Your Cvent account password.";
$string['enrol_cvent_searchdays'] = "Default: \$a. The number of days into the future to search. (All events active between now and this many days into the future will be included.)";
$string['enrol_cvent_search_location'] = "The beginning of the name of the location(s) you wish to include.<br />\nFor example: If you have three locations in Cvent (Town, Town Hall, Courthouse) and you want this moodle to get enrolments for events in Town and Town Hall, enter 'Town' here.";
$string['enrol_cvent_autocreate_header'] = "Auto-creation of new courses";
$string['enrol_cvent_autocreate_courses'] = "Courses can be created automatically (with the correct ID numbers) if there are enrolments to a course that doesn't yet exist in Moodle.";
$string['enrol_cvent_autocreate_category'] = "The category for auto-created courses.";
$string['INVALID_LOGIN'] = "Cvent returned 'INVALID_LOGIN'. Please check your configured Cvent account number, username, and password.\n";
$string['attemptinginit'] = "Attempting to authenticate to Cvent...\n";
$string['initerrorunknown'] = "Unknown error authenticating to Cvent. Perhaps you want to turn on Moodle debugging and try again.\n";
$string['initsuccess'] = "Successfully authenticated to Cvent!\n";
$string['setup_enrolments'] = "Setting up enrolments for \$a...<br />\n";
$string['apicallsremaining'] = "API calls remaining today until Midnight, Eastern time: \$a\n";
$string['headingcallsmade'] = "API calls made (by this plugin)";
$string['headingcallsremaining'] = "API calls remaining";
$string['viewlog'] = "view log";
$string['couldnotinit'] = "Cvent could not be initialized; the number of API calls remaining today is unknown.";
$string['youmustsetdatetimezone'] = "Error: date.timezone is not set in your php.ini. You must set this parameter before the Cvent enrolment plugin can work.";
$string['manualsync'] = "Synchronize now";
$string['clicktoseelogafter'] = "Click here to see the API calls log after this page is finished loading.";

?>

