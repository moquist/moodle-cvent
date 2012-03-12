<?php

require_once(dirname(dirname(dirname(__FILE__))).'/config.php'); // global moodle config file.
require_once(dirname(__FILE__).'/lib.php'); // global moodle config file.
require_capability('moodle/site:viewparticipants', get_context_instance(CONTEXT_SYSTEM, SITEID));

$date = get_string('date');
$callsmade = get_string('headingcallsmade', 'enrol_cvent');
$callsremaining = get_string('headingcallsremaining', 'enrol_cvent');

print <<<EOF
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
    <html><body>
<table border="1" cellspacing="0" cellpadding="2">
<tr><th>$date</th><th>$callsmade</th><th>$callsremaining</th></tr>
EOF;

#$PAGE->set_context(get_context_instance(CONTEXT_SYSTEM));
#$OUTPUT->header();

$enrol = new enrol_cvent_plugin();
#$apicalls_made = get_string('apicallsmade', 'enrol_cvent', $enrol->apicalls_log()->calls_made);
$strmanualsunc = get_string('manualsync', 'enrol_cvent');
$manualsync = "<a target=\"_blank\" href=\"$CFG->wwwroot/enrol/cvent/cli/sync.php?latestupdate=null\">$strmanualsunc</a>";

print "
    <p>$manualsync</p>
";
foreach($DB->get_records('enrol_cvent_apicalls_log', null, 'yyyymmdd DESC') as $apicalls_log) {
    $date = preg_replace('/(....)(..)(..)/', '$1-$2-$3', $apicalls_log->yyyymmdd);
    print "<tr><td>$date</td><td style=\"text-align:right\">$apicalls_log->calls_made</td><td style=\"text-align:right\">$apicalls_log->calls_remaining</td></tr>\n";
}
print "</table></body></html>";

?>
