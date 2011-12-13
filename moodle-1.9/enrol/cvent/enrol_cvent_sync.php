<?php // $Id$

# Call this from the command line to do regular synchronization. This is also 
# called when a Moodle admin clicks the synchronize-now link on the config page.
#
# From the CLI, pass '--latestupdate null' to re-fetch all Cvent data without 
# limiting to updates since the most recent synchronization.
#
# Using your browser, pass latestupdate=null to accomplish the same thing. The 
# synchronize-now link on the config page passes this param by default to 
# provide an easy way to re-pull all Cvent data.

    require_once(dirname(dirname(dirname(__FILE__))) . "/config.php");
    global $CFG;
    require_once("$CFG->libdir/accesslib.php");

    if (!has_capability('moodle/site:doanything', get_context_instance(CONTEXT_SYSTEM, SITEID)) and PHP_SAPI != 'cli') {
        print "Must be admin or must run from CLI!";
        exit;
    }

    $latestupdate = null;
    if (PHP_SAPI == 'cli') {
        if (array_search('--latestupdate', $argv) !== false) {
            $latestupdate = $argv[count($argv)-1];
        }
    } else {
        $latestupdate = optional_param('latestupdate', null, PARAM_TEXT);
    }
    if (isset($latestupdate)) {
        print "using latestupdate = $latestupdate\n";
    }

    error_reporting(E_ALL);

    require_once(dirname(dirname(dirname(__FILE__))).'/config.php'); // global moodle config file.

    require_once(dirname(__FILE__) . "/enrol.php");


    // ensure errors are well explained
    $CFG->debug=E_ALL;

    if (!is_enabled_enrol('cvent')) {
         error_log("CVent enrolment plugin not enabled!");
         die;
    }

    $enrol = new enrolment_plugin_cvent();

    if (PHP_SAPI != 'cli') {
        print "<p><big><big><a target=\"_blank\" href=\"$CFG->wwwroot/enrol/cvent/apicalls_history.php\">(" . get_string('clicktoseelogafter', 'enrol_cvent') . ")</a></big></big></p>";
    }
    $enrol->sync_enrolments(null, $latestupdate);
?>
