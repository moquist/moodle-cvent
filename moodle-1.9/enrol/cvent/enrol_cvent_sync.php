<?php // $Id$

    if (PHP_SAPI != 'cli') {
        error_log("Must be called from CLI!");
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
