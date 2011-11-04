<?php
/*
 * This script lets you test some aspects of your Cvent enrolment plugin.
 * This isn't very polished yet, but you should be able to run it immediately to 
 * do a basic test of authentication of your moodle to your Cvent account. 
 * Here's an example of how that might look on a linux system if you've 
 * configured your Cvent account correctly in this cvent enrolment plugin:

$ php /var/www/moodle/enrol/cvent/test.php
Attempting to authenticate to Cvent...
Successfully authenticated to Cvent!
You have 4978 API calls remaining between now and midnight Eastern.

 */

if (PHP_SAPI != 'cli') {
    error_log("Must be called from CLI!");
    exit;
}

error_reporting(E_ALL);
require_once(dirname(dirname(dirname(__FILE__))).'/config.php'); // global moodle config file.
require_once(dirname(__FILE__) . "/enrol.php");

// ensure errors are well explained
$CFG->debug = E_ALL;

if (!is_enabled_enrol('cvent')) {
    error_log("Cvent enrolment plugin not enabled!");
    die;
}

main($argv);
exit;


#####################################################################
# Functions.
#####################################################################

function main($argv) {
    $enrol = new enrolment_plugin_cvent();

    if (array_search('--help', $argv) !== false or array_search('--help', $argv) !== false) {
        usage();
    }

    try {
        print_string("attemptinginit", 'enrol_cvent');
        if (!$apicalls_log = $enrol->init_cvent()) {
            print_string('initerrorunknown', 'enrol_cvent');
            exit;
        }
    } catch (Exception $e) {
        if ($e->faultstring == 'INVALID_LOGIN') {
            print_string($e->faultstring, 'enrol_cvent');
        }
        throw $e;
    }
    print_string("initsuccess", 'enrol_cvent');
    print_string("apicallsremaining", 'enrol_cvent', $apicalls_log->calls_remaining);
    $init_calls_remaining = $apicalls_log->calls_remaining;

    if (array_search('--events', $argv) !== false) {
        print "testing get_events({$argv[count($argv)-1]})\n";
        $events = $enrol->get_events($argv[count($argv)-1]);
        $id = '';
        $lmd = '';
        $startdate = '';
        $enddate = '';
        $title = '';
        foreach ($events as $camel_event) {
            foreach (get_object_vars($camel_event) as $key => $val) {
                $key = strtolower($key);
                if ($key == 'id') {
                    $id = $val;
                } elseif ($key == 'lastmodifieddate') {
                    $lmd = $val;
                } elseif ($key == 'eventstartdate') {
                    $startdate = $val;
                } elseif ($key == 'eventenddate') {
                    $enddate = $val;
                } elseif ($key == 'eventtitle') {
                    $title = $val;
                }
            }
            print "search returned eventid: $id with EventTitle ($title), EventStartDate ($startdate), EventEndDate ($enddate), and LastModifiedDate ($lmd)\n";
        }

    }

    if (array_search('--registrations', $argv) !== false) {
        print "testing get_registrations({$argv[count($argv)-1]})\n";
        $registrations = $enrol->get_registrations($argv[count($argv)-1]);
        $id = '';
        $lmd = '';
        foreach ($registrations as $camel_registration) {
            foreach (get_object_vars($camel_registration) as $key => $val) {
                $key = strtolower($key);
                if ($key == 'id') {
                    $id = $val;
                } elseif ($key == 'lastmodifieddate') {
                    $lmd = $val;
                }
            }
            print "search returned registrationid: $id with LastModifiedDate $lmd\n";
        }
    }

    if (array_search('--contacts', $argv) !== false) {
        print "testing get_contacts({$argv[count($argv)-1]})\n";
        print_r($enrol->get_contacts($argv[count($argv)-1]));
    }

    $apicalls_log = $enrol->apicalls_log();
    if ($apicalls_log->calls_remaining != $init_calls_remaining) {
        print_string("apicallsremaining", 'enrol_cvent', $apicalls_log->calls_remaining);
    }
    return;
}

function usage() {
    print "Usage:
        php test.php [ --events ] [ --registrations ] [ --contacts ] { <latestupdate date as GMT: YYYY-MM-DDTHH:MM:SS> | 'null' }
        With no options, test.php will try to authenticate to Cvent and tell you how it goes.
        ";
    exit;
}

?>
