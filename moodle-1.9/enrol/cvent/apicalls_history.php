<?php

require_once(dirname(dirname(dirname(__FILE__))).'/config.php'); // global moodle config file.
require_capability('moodle/site:doanything', get_context_instance(CONTEXT_SYSTEM, SITEID));

$date = get_string('date');
$callsmade = get_string('headingcallsmade', 'enrol_cvent');
$callsremaining = get_string('headingcallsremaining', 'enrol_cvent');

print <<<EOF
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
    <html><body>
<table border="1" cellspacing="0" cellpadding="2">
<tr><th>$date</th><th>$callsmade</th><th>$callsremaining</th></tr>
EOF;
foreach(get_records('cvent_apicalls_log', '', '', 'yyyymmdd DESC') as $apicalls_log) {
    #$yyyymmdd = preg_split('//', $apicalls_log->yyyymmdd);
    #$date = implode('', array_slice($yyyymmdd, 0, 5)) . '-' . implode('', array_slice($yyyymmdd, 5, 2)) . '-' . implode('', array_slice($yyyymmdd, 7, 2));
    $date = preg_replace('/(....)(..)(..)/', '$1-$2-$3', $apicalls_log->yyyymmdd);
    print "<tr><td>$date</td><td style=\"text-align:right\">$apicalls_log->calls_made</td><td style=\"text-align:right\">$apicalls_log->calls_remaining</td></tr>\n";
}
print "</table></body></html>";

?>
