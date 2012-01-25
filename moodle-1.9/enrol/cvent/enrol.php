<?php
// $Id$
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

global $CFG;

# Old integration:
# mdl_course.idnumber = Event.EventCode
#     - Rob Stockman sets up moodle courses and enters this manually to match up moodle content with Cvent events
# mdl_course.FK_CventEventGuid = Event.Id
#     - used for Upcoming Courses area of landing page http://www.wilmetteinstitute.us.bahai.org/
#     - just keep updating this for now

define('CV_DATEFORMAT', 'Y-m-d\TH:i:s'); # It's almost (but not quite!) DATE_ISO8601
define('CV_ACCEPTED', 'Accepted');
define('CV_CANCELLED', 'Cancelled');

# TODO: Test what happens when the last registrant for an event signs up. Does it work? (See email from Rolando on July 5)

require_once($CFG->dirroot.'/enrol/enrol.class.php');
require_once($CFG->dirroot.'/course/lib.php');
require_once($CFG->dirroot.'/group/lib.php');
require_once(dirname(__FILE__) . '/CVentV200611.php');

class enrolment_plugin_cvent {
    # This will be our cvent object to make API calls.
    private $cvent = false;

    private $config_vars = array(
        'enrol_cvent_account_number' => '',
        'enrol_cvent_username' => '',
        'enrol_cvent_password' => '',
        'enrol_cvent_searchdays' => 180,
        'enrol_cvent_search_location' => '',
        'enrol_cvent_autocreate_courses' => '',
        'enrol_cvent_autocreate_category' => '',
        'enrol_cvent_cron_frequency' => '',
    );

    /*
     * For the given user, look in the Cvent data pile for an authoritative list
     * of enrolments, and then adjust the local Moodle assignments to match.
     * TODO: remove old enrollments
     */
    public function setup_enrolments(&$user) {
        global $CFG;
        if ($contact = get_record('cvent_contact', 'emailaddress', $user->username)) {
            # Ensure enrollment for each course where this contact is registered.
            foreach (get_records_select('cvent_registration', "contactid = '$contact->contactid' AND status = '".CV_ACCEPTED."'") as $reg) {
                $this->ensure_enrolment($reg->registrationid, $user);
            }
        }
        if ($guestings = get_records_sql("SELECT g.* FROM {$CFG->prefix}cvent_registration_guest g JOIN {$CFG->prefix}cvent_registration r ON r.registrationid = g.registrationid WHERE g.emailaddress = '$user->username' AND r.status = '".CV_ACCEPTED."'")) {
            # Ensure enrollment for each course where this contact is a Cvent-guest.
            foreach ($guestings as $guesting) {
                $this->ensure_enrolment($guesting->registrationid, $user);
            }
        }
        return true;
    }

    /**
     * sync ALL DATA (including enrolments & users) with CVent, cache info locally
     *
     * @param object IGNORED FOR NOW: The role to sync for. If no role is
     * specified, defaults are used.
     * @param bool $latestupdate if null (the default value), behavior is
     * normal, else if 'null' (the string) none of the GetUpdated() calls are
     * made. This can be used to reset records that have been pulled previously
     * in case any corrections need to be made in local data.
     */
    public function sync_enrolments($role=null, $latestupdate=null) {
        global $CFG;
        error_reporting(E_ALL);

        $this->init_cvent();

        // first, pack the sortorder...
        fix_course_sortorder();

        try {
            $this->sync_events($latestupdate);
            $this->sync_registrations($latestupdate);
            $this->sync_contacts($latestupdate);

            # TODO: make this faster and more efficient
            foreach (get_records('user') as $user) {
                cvent_safe_print(get_string('setup_enrolments', 'enrol_cvent', $user->username));
                $this->setup_enrolments($user);
            }
        } catch (Exception $e) {
            cvent_safe_print("Exception SOAP info: " . $this->get_soap_trace() . "<br />\n");
            throw $e;
        }
        return true;
    }

    function config_form($frm) {
        global $CFG;

        $apicalls_remaining = $this->apicalls_log()->calls_remaining;
        if (!strlen($apicalls_remaining)) {
            if ($this->init_cvent()) {
                $apicalls_remaining = $this->apicalls_log()->calls_remaining;
            }
        }
        if (!strlen($apicalls_remaining)) {
            $apicalls_remaining = get_string('couldnotinit', 'enrol_cvent');
        } else {
            $apicalls_made = get_string('apicallsmade', 'enrol_cvent', $this->apicalls_log()->calls_made);
            $apicalls_remaining = get_string('apicallsremaining', 'enrol_cvent', $this->apicalls_log()->calls_remaining);
            $apicalls_remaining .= " <a target=\"_blank\" href=\"$CFG->wwwroot/enrol/cvent/apicalls_history.php\">(" . get_string('viewlog', 'enrol_cvent') . ")</a>";
        }

        $strmanualsunc = get_string('manualsync', 'enrol_cvent');
        $manualsync = "<a target=\"_blank\" href=\"$CFG->wwwroot/enrol/cvent/enrol_cvent_sync.php?latestupdate=null\">$strmanualsunc</a>";

        foreach ($this->config_vars as $var => $default) {
            if (!isset($frm->$var)) {
                $frm->$var = $default;
            }
            $defstring = $var.'_default';
            $frm->$defstring = $default;
        }
        include("$CFG->dirroot/enrol/cvent/config.html");
    }

    function process_config($config) {
        foreach ($this->config_vars as $var => $default) {
            if (isset($config->$var)) {
                set_config($var, $config->$var);
            }
        }

        return true;
    }


    /**
     * Initialize and store the CVent SOAP object; log in to CVent.
     */
    public function init_cvent() {
        global $CFG;

        if (!is_enabled_enrol('cvent')) {
            debugging('cvent enrolment plugin not enabled, cannot init');
            return false;
        }

        if ($this->cvent instanceof CVentV200611) {
            # Only init once.
            return $this->cvent;
        }
        $this->cvent = new CVentV200611();
        if (!($this->cvent instanceof CVentV200611)) {
            throw new Exception ('cvent instantiation problem');
        }
        if (!strlen($CFG->enrol_cvent_account_number) or !strlen($CFG->enrol_cvent_username) or !strlen($CFG->enrol_cvent_password)) {
            debugging('cvent missing account number, username, or password');
            return false;
        }

        $login = new Login(array('AccountNumber' => $CFG->enrol_cvent_account_number, 'UserName' => $CFG->enrol_cvent_username, 'Password' => $CFG->enrol_cvent_password));
        $this->cvent->Login($login);
        return $this->cvent->DescribeGlobal(new DescribeGlobal());
    }

    private function ensure_course($event) {
        global $CFG;
        if (!$course = get_record('course', 'idnumber', $event->eventcode)) {
            cvent_safe_print("Missing course \"$event->eventtitle\" with EventCode $event->eventcode<br />\n");
            if (!isset($CFG->enrol_cvent_autocreate_courses) or !$CFG->enrol_cvent_autocreate_courses) {
                return false;
            }
            $categoryid = get_record_select('course_categories', '', 'MIN(id) AS categoryid')->categoryid;
            if (isset($CFG->enrol_cvent_autocreate_category) and $CFG->enrol_cvent_autocreate_category) {
                $categoryid = $CFG->enrol_cvent_autocreate_category;
            }
            cvent_safe_print("Auto-creating course \"$event->eventtitle\" with EventCode $event->eventcode<br />\n");
            $course = create_course((object)array(
                'fullname' => $event->eventtitle,
                'shortname' => $event->eventtitle,
                'idnumber' => $event->eventcode,
                'startdate' => strtotime($event->eventstartdate),
                'category' => $categoryid,
                'visible' => 1,
                'groupmode' => 1, # Separate Groups
                'enrolstartdate' => time(),
                'fk_cventeventguid' => $event->eventid,
            ));
        } else {
            if (!isset($course->fk_cventeventguid) or $course->fk_cventeventguid != $event->eventid) {
                $course->fk_cventeventguid = $event->eventid;
                $course = addslashes_object($course);
                update_record('course', $course);
            }
        }
    }

    private function ensure_course_group($course, $groupname) {
        static $ids = array();
        $key = "$course->id:$groupname";
        if (!isset($ids[$key])) {
            if ($group = get_record('groups', 'courseid', $course->id, 'name', addslashes($groupname))) {
                $ids[$key] = $group->id;
            } else {
                $ids[$key] = groups_create_group((object)array('courseid' => $course->id, 'name' => addslashes($groupname)));
            }
        }
        return $ids[$key];
    }

    private function generate_groupname($contact) {
        if (isset($contact->groupname) and strlen($contact->groupname)) {
            return get_string('group') . ": $contact->lastname, $contact->firstname ($contact->contactid)";
        }
        return get_string('default');
    }

    private function ensure_enrolment($registrationid, $user) {
        global $CFG;

        static $registrations = array();
        if (!isset($registrations[$registrationid])) {
            $registrations[$registrationid] = get_record('cvent_registration', 'registrationid', $registrationid, 'status', CV_ACCEPTED);
        }
        $reg = $registrations[$registrationid];

        static $events = array();
        if (!isset($events[$reg->eventid])) {
            $events[$reg->eventid] = get_record('cvent_event', 'eventid', $reg->eventid);
        }
        $event = $events[$reg->eventid];

        # Bail out now if the course doesn't exist yet.
        if (!$course = get_record('course', 'idnumber', $event->eventcode)) {
            # The course hasn't been created yet, just fail.
            return false;
        }

        static $contacts = array();
        if (!isset($contacts[$reg->contactid])) {
            $contacts[$reg->contactid] = get_record('cvent_contact', 'contactid', $reg->contactid);
        }
        $contact = $contacts[$reg->contactid];

        $groupname = $this->generate_groupname($contact);
        $groupid = $this->ensure_course_group($course, $groupname);
        groups_add_member($groupid, $user->id);

        // if the course is hidden and we don't want to enrol in hidden courses
        // then just skip it
        if (!$course->visible and $CFG->enrol_cvent_ignorehiddencourse) {
            return;
        }

        $role = get_default_course_role($course);

        if (!$context = get_context_instance(CONTEXT_COURSE, $course->id)) {
            throw new Exception("Missing course context instance");
            return;
        }

        if (!$existing = get_records('role_assignments', 'userid', $user->id)) {
            $existing = array();
        }

        // Search the role assignments to see if this user
        // already has a role in this context.  If so, we're done.
        foreach($existing as $key => $role_assignment) {
            if ($role_assignment->contextid == $context->id) {
                    // User is already enroled in course
                    # ... but as a what?
                    return;
                }
        }

        return role_assign($role->id, $user->id, 0, $context->id, 0, 0, 0, 'cvent');
    }

    /**
     * Return tracing information (headers & XML) from the SOAP client.
     *
     * @return string last request headers & last request
     */
    public function get_soap_trace() {
        return "__getLastRequestHeaders:\n"
            . $this->cvent->__getLastRequestHeaders()
            . "__getLastRequest:\n"
            . $this->cvent->__getLastRequest()
            . "__getLastResponseHeaders:\n"
            . $this->cvent->__getLastResponseHeaders()
            . "__getLastResponse:\n"
            . $this->cvent->__getLastResponse()
            . "\n";
    }

    public function get_events($latestupdate=null) {
        global $CFG;

        $searchdays = $this->config_vars['enrol_cvent_searchdays'];
        if (isset($CFG->enrol_cvent_searchdays)) {
            $searchdays = $CFG->enrol_cvent_searchdays;
        }

        $search_location = $this->config_vars['enrol_cvent_search_location'];
        if (isset($CFG->enrol_cvent_search_location)) {
            $search_location = $CFG->enrol_cvent_search_location;
        }

        # Search for active events that have been updated.
        $filters = array(
            new Filter(array(
                'Field' => 'EventEndDate',
                'Operator' => CvSearchOperatorType::Greater_than_or_Equal_to,
                'Value' => date('m/d/Y'),
            )),
            new Filter(array(
                'Field' => 'EventStartDate',
                'Operator' => CvSearchOperatorType::Less_than_or_Equal_to,
                'Value' => date('m/d/Y', time() + ($searchdays * 60 * 60 * 24)),
            )),
        );

        if (strlen($search_location)) {
            $filters[] = new Filter(array(
                'Field' => 'Location',
                'Operator' => CvSearchOperatorType::Starts_with,
                'Value' => $search_location,
            ));
        }

        $searchresults = $this->cvent->Search(
            new Search(array(
                'ObjectType' => CvObjectType::Event,
                'CvSearchObject' => new CvSearch(array(
                    'Filter' => $filters,
                    'SearchType' => CvSearchType::AndSearch
                ))
            ))
        );
        if (!isset($searchresults->SearchResult)) {
            return false;
        }
        $search_ids = is_array($searchresults->SearchResult->Id) ? $searchresults->SearchResult->Id : array($searchresults->SearchResult->Id);
        $ids = $search_ids;

        if (!isset($latestupdate)) {
            if ($tmp = get_record_sql("SELECT MAX(events_latestupdate) AS latestupdate FROM {$CFG->prefix}cvent_apicalls_log")) {
                $latestupdate = gmdate(CV_DATEFORMAT, $tmp->latestupdate);
            }
        }
        $events_latestupdate = time() - 120; # lop of 2 minutes in case of clock skew
        if ($latestupdate != 'null' and isset($latestupdate)) {
            $getupdated_ids = $this->cvent->GetUpdated(
                new GetUpdated(array(
                    'ObjectType' => CvObjectType::Event,
                    'StartDate' => $latestupdate,
                    'EndDate' => gmdate(CV_DATEFORMAT, $events_latestupdate),
                ))
            );
            $ids = array_intersect($search_ids, $getupdated_ids);
        }
        $this->cvent->apicalls_log(false, null, array('events_latestupdate' => $events_latestupdate));

        return $this->cvent->retrieve_pages(CvObjectType::Event, $ids);
    }

    private function sync_events($latestupdate=null) {
        $camel_events = $this->get_events($latestupdate);
        foreach ($camel_events as $camel_event) {
            $event = (object)array();
            foreach (get_object_vars($camel_event) as $key => $val) {
                $key = strtolower($key);
                if (!is_array($val) and !is_object($val)) {
                    if (isset($val)) {
                        switch($key) {
                        case 'id':
                            $key = 'eventid';
                            break;
                        case 'hidden':
                            # handle the bool
                            $val = $val ? 1 : 0;
                            break;
                        }
                        $event->$key = addslashes($val);
                    }
                }
            }
            if ($rec = get_record('cvent_event', 'eventid', $event->eventid)) {
                # Update this record.
                $event->id = $rec->id;
                cvent_safe_print("Updating event ($event->eventid)<br />\n");
                update_record('cvent_event', $event);
                $this->ensure_course($event);
            } else {
                # Insert this record.
                cvent_safe_print("Inserting event ($event->eventid)<br />\n");
                insert_record('cvent_event', $event);
                $this->ensure_course($event);
            }
        }
    }

    /**
     * Search for the registrations pertaining to our events.
     * Get all the updated registrations. (Cvent's Search() call has a bug and does not correctly search on LastModifiedDate.)
     * Find the intersection of these two result lists.
     * Retrieve the intersection.
     */
    public function get_registrations($latestupdate=null) {
        global $CFG;

        if (!$eventids = get_records_select('cvent_event', '', '', 'eventid')) {
            print "cannot get_registrations without knowing eventids<br />\n";
            return false;
        }
        $filters = array(
            new Filter(array(
                'Field' => 'EventId',
                'Operator' => CvSearchOperatorType::Includes,
                'ValueArray' => array_keys($eventids),
                #'ValueArray' => array('455D655E-742E-4572-829D-D28CA6D64CBB'),
            )),
        );

        $searchresults = $this->cvent->Search(
            new Search(array(
                'ObjectType' => CvObjectType::Registration,
                'CvSearchObject' => new CvSearch(array(
                    'Filter' => $filters,
                    'SearchType' => CvSearchType::AndSearch
                ))
            ))
        );
        if (!isset($searchresults->SearchResult)) {
            print "no regresults!<br />\n";
            return false;
        }
        $search_ids = is_array($searchresults->SearchResult->Id) ? $searchresults->SearchResult->Id : array($searchresults->SearchResult->Id);
        $ids = $search_ids;

        if (!isset($latestupdate)) {
            if ($tmp = get_record_sql("SELECT MAX(registrations_latestupdate) AS latestupdate FROM {$CFG->prefix}cvent_apicalls_log")) {
                $latestupdate = gmdate(CV_DATEFORMAT, $tmp->latestupdate);
            }
        }
        $registrations_latestupdate = time() - 120; # lop of 2 minutes in case of clock skew
        if ($latestupdate != 'null' and isset($latestupdate)) {
            $getupdated_ids = $this->cvent->GetUpdated(
                new GetUpdated(array(
                    'ObjectType' => CvObjectType::Registration,
                    'StartDate' => $latestupdate,
                    'EndDate' => gmdate(CV_DATEFORMAT, $registrations_latestupdate),
                ))
            );
            $ids = array_intersect($search_ids, $getupdated_ids);
        }
        $this->cvent->apicalls_log(false, null, array('registrations_latestupdate' => $registrations_latestupdate));

        return $this->cvent->retrieve_pages(CvObjectType::Registration, $ids);
    }

    /**
     * Return the apicalls_log for today.
     */
    public function apicalls_log() {
        return CVentV200611::apicalls_log();
    }

    private function sync_registrations($latestupdate=null) {
        if (!$camel_registrations = $this->get_registrations($latestupdate)) {
            print "no new/updated registrations gotten<br />\n";
            return false;
        }
        foreach ($camel_registrations as $camel_registration) {
            $registration = (object)array();
            $guestdetails = null;
            foreach (get_object_vars($camel_registration) as $key => $val) {
                $key = strtolower($key);
                if (!is_array($val) and !is_object($val)) {
                    if (isset($val)) {
                        switch($key) {
                        case 'id':
                            $key = 'registrationid';
                            break;
                        case 'participant':
                            # handle the bool
                            $val = $val ? 1 : 0;
                            break;
                        }
                        $registration->$key = addslashes($val);
                    }
                } elseif ($key == 'guestdetail') {
                    $guestdetails = $val;
                }
            }
            if ($rec = get_record('cvent_registration', 'registrationid', $registration->registrationid)) {
                $registration->id = $rec->id;
                cvent_safe_print("Updating registration ($registration->registrationid)<br />\n");
                update_record('cvent_registration', $registration);
            } else {
                cvent_safe_print("Inserting registration ($registration->registrationid)<br />\n");
                insert_record('cvent_registration', $registration);
            }
            if (isset($guestdetails)) {
                if (is_object($guestdetails)) {
                    $guestdetails = array($guestdetails);
                }
                $this->handle_registration_guestdetail($registration->registrationid, $guestdetails);
            }
        }
    }

    private function handle_registration_guestdetail($registrationid, $guestdetails) {
        foreach ($guestdetails as $camel_guestdetail) {
            $guestdetail = (object)array();
            $guestdetail->registrationid = $registrationid;
            foreach (get_object_vars($camel_guestdetail) as $key => $val) {
                $key = strtolower($key);
                if (!is_array($val) and !is_object($val)) {
                    if (isset($val)) {
                        switch($key) {
                        case 'participant':
                            # handle the bool
                            $val = $val ? 1 : 0;
                            break;
                        }
                        $guestdetail->$key = addslashes($val);
                    }
                }
            }
            if ($rec = get_record('cvent_registration_guest', 'guestid', $guestdetail->guestid)) {
                $guestdetail->id = $rec->id;
                cvent_safe_print("Updating guestdetail ($guestdetail->guestid)<br />\n");
                update_record('cvent_registration_guest', $guestdetail);
            } else {
                cvent_safe_print("Inserting guestdetail ($guestdetail->guestid)<br />\n");
                insert_record('cvent_registration_guest', $guestdetail);
            }
            $guestdetail->homeaddress1 = $guestdetail->address1;
            $guestdetail->homecity = $guestdetail->city;
            $guestdetail->homecountrycode = $guestdetail->countrycode;
            $user = cvent_ensure_user($guestdetail);
            # The enrolment will be handled later by setup_enrolments()
        }
    }

    public function get_contacts($latestupdate=null) {
        global $CFG;

        if (!$contactids = get_records_select('cvent_registration', '', '', 'contactid')) {
            print "cannot get_contacts without known registrations<br />\n";
            return false;
        }
        $filters = array(
            new Filter(array(
                'Field' => 'Id',
                'Operator' => CvSearchOperatorType::Includes,
                'ValueArray' => array_keys($contactids),
            )),
        );
        $searchresults = $this->cvent->Search(
            new Search(array(
                'ObjectType' => CvObjectType::Contact,
                'CvSearchObject' => new CvSearch(array(
                    'Filter' => $filters,
                    'SearchType' => CvSearchType::AndSearch
                ))
            ))
        );
        if (!isset($searchresults->SearchResult)) {
            return false;
        }
        $search_ids = is_array($searchresults->SearchResult->Id) ? $searchresults->SearchResult->Id : array($searchresults->SearchResult->Id);
        $ids = $search_ids;


        if (!isset($latestupdate)) {
            if ($tmp = get_record_sql("SELECT MAX(contacts_latestupdate) AS latestupdate FROM {$CFG->prefix}cvent_apicalls_log")) {
                $latestupdate = gmdate(CV_DATEFORMAT, $tmp->latestupdate);
            }
        }
        $contacts_latestupdate = time() - 120; # lop off 2 minutes in case of clock skew
        if ($latestupdate != 'null' and isset($latestupdate)) {
            $getupdated_ids = $this->cvent->GetUpdated(
                new GetUpdated(array(
                    'ObjectType' => CvObjectType::Contact,
                    'StartDate' => $latestupdate,
                    'EndDate' => gmdate(CV_DATEFORMAT, $contacts_latestupdate),
                ))
            );
            $ids = array_intersect($search_ids, $getupdated_ids);
        }
        $this->cvent->apicalls_log(false, null, array('contacts_latestupdate' => $contacts_latestupdate));

        return $this->cvent->retrieve_pages(CvObjectType::Contact, $ids);
    }

    private function sync_contacts($latestupdate=null) {
        if (!$camel_contacts = $this->get_contacts($latestupdate)) {
            print "no new/updated contacts gotten<br />\n";
            return false;
        }
        foreach ($camel_contacts as $camel_contact) {
            $contact = (object)array();
            foreach (get_object_vars($camel_contact) as $key => $val) {
                $key = strtolower($key);
                if (!is_array($val) and !is_object($val)) {
                    if (isset($val)) {
                        switch($key) {
                        case 'id':
                            $key = 'contactid';
                            break;
                        case 'active':
                        case 'excludedfromemail':
                        case 'optedin':
                            # handle the bools
                            $val = $val ? 1 : 0;
                            break;
                        }
                        $contact->$key = addslashes($val);
                    }
                } elseif ($key == 'customfielddetail') {
                    # Super-special handling for a custom group name field!
                    foreach ($val as $customfield) {
                        if (strtolower($customfield->FieldName) == 'group name') {
                            $contact->groupname = addslashes($customfield->FieldValue);
                        }
                    }
                }
            }
            if ($rec = get_record('cvent_contact', 'contactid', $contact->contactid)) {
                $contact->id = $rec->id;
                cvent_safe_print("Updating contact ($contact->contactid)<br />\n");
                update_record('cvent_contact', $contact);
            } else {
                cvent_safe_print("Inserting contact ($contact->contactid)<br />\n");
                $contact->id = insert_record('cvent_contact', $contact);
            }
            $user = cvent_ensure_user($contact);
            # Enrolments for this user will be handled later by setup_enrolments()
        }
    }

    /**
     * Synchronize with Cvent if we're configured to do so.
     * This function is run by admin/cron.php
     * @return void
     */
    function cron() {
        global $CFG;
        if (!isset($CFG->enrol_cvent_cron_frequency) or empty($CFG->enrol_cvent_cron_frequency)) {
            mtrace(get_string('enrol_cvent_nocron', 'enrol_cvent'));
            return;
        }
        # There is no mdl_enrol table with a lastcron field.
        # I will use mdl_config *and not feel guilty*!
        $lastcron = isset($CFG->enrol_cvent_lastcron) ? $CFG->enrol_cvent_lastcron : 0;
        $now = time();
        $untilnextcron = ($lastcron + ($CFG->enrol_cvent_cron_frequency * 60)) - $now;
        if ($untilnextcron > 0) {
            # Round to at least one minute.
            $untilnextcron = intval($untilnextcron / 60) + 1;
            mtrace(get_string('enrol_cvent_nocron_now', 'enrol_cvent', $untilnextcron));
            return;
        }
        mtrace(get_string('enrol_cvent_cron_now', 'enrol_cvent'));
        $this->sync_enrolments();
        mtrace('done');
        set_config('enrol_cvent_lastcron', $now);
    }

} // end of class

/**
 * Ensure that the given CVent Contact object has a corresponding Moodle
 * user account.
 *
 * @param object $contact A CVent Contact object
 * @return
 */
function cvent_ensure_user($contact) {
    global $CFG;
    if (!strlen($contact->emailaddress)) {
        cvent_safe_print("$contact->lastname, $contact->firstname ($contact->homephone) has no email address, skipping account creation/update<br />\n");
    }
    $user = (object)array(
        'auth' => 'manual',
        'confirmed' => 1,
        'mnethostid' => $CFG->mnet_localhost_id,
        'username' => $contact->emailaddress,
        'firstname' => $contact->firstname,
        'lastname' => $contact->lastname,
        'email' => $contact->emailaddress,
        'lang' => 'en_utf8', # default can be changed by user
        'address' => $contact->homeaddress1,
        'city' => substr($contact->homecity, 0, 20), # for moodle 1.9, truncate the city
        'country' => $contact->homecountrycode,
        'idnumber' => isset($contact->contactid) ? $contact->contactid : '',
    );
    if ($rec = get_record('user', 'username', $user->username)) {
        $user->id = $rec->id;
        update_record('user', $user);
    } else {
        # We need to create this user.
        $user->password = hash_internal_user_password($contact->emailaddress);
        $user->id = insert_record('user', $user);
        $userpref = insert_record('user_preferences', (object)array(
            'userid' => $user->id,
            'name' => 'auth_forcepasswordchange',
            'value' => 1,
        ));
    }
    return $user;
}

/**
 * Output the specified string to a secure display. Since cron.php runs as
 * admin, the only safe output ATM is the CLI. If we're not running in the CLI,
 * output goes to error_log().
 *
 * @param $str The string to be printed somewhere.
 */
function cvent_safe_print($str) {
    if (PHP_SAPI == 'cli') {
        print $str;
    } else {
        error_log($str);
    }
    return;
}

?>
