<?php // $Id$

    require_once(dirname(dirname(dirname(__FILE__))) . "/config.php");
    global $CFG;
    require_once("$CFG->libdir/accesslib.php");

    if (!has_capability('moodle/site:doanything', get_context_instance(CONTEXT_SYSTEM, SITEID)) and PHP_SAPI != 'cli') {
        error_log("Must be admin or must run from CLI!");
        exit;
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

    $enrol->sync_enrolments();
?>
