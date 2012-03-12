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

    if (PHP_SAPI == 'cli') {
        define('CLI_SCRIPT', 1);
    }
    require_once(dirname(dirname(dirname(dirname(__FILE__)))) . "/config.php");
    require_once(dirname(dirname(__FILE__)) . "/lib.php");

    $latestupdate = null;

    if (CLI_SCRIPT) {
        if (array_search('--latestupdate', $argv) !== false) {
            $latestupdate = $argv[count($argv)-1];
        }
    } elseif (is_siteadmin()) {
        $latestupdate = optional_param('latestupdate', null, PARAM_TEXT);
    } else {
        print_error(get_string('enrol_cvent_mustbeadmin', 'enrol_cvent'));
    }

    error_reporting(E_ALL);
    cvent_force_sync($latestupdate);
?>
