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


# TODO: Test what happens when the last registrant for an event signs up. Does it work? (See email from Rolando on July 5)

require_once(dirname(__FILE__) . '/CVentV200611.php');
require_once(dirname(__FILE__) . '/defines.php');

class enrol_cvent_plugin extends enrol_plugin {
    # This will be our cvent object to make API calls.
    private $cvent = false;

    /*
     * For the given user, look in the Cvent data pile for an authoritative list
     * of enrolments, and then adjust the local Moodle assignments to match.
     * TODO: remove old enrollments
     *
     */
    public function sync_user_enrolments($user) {
        global $DB;
        $enrols = array();

        # Enrol!
        if ($contacts = $DB->get_records('enrol_cvent_contact', array('emailaddress' => $user->username))) {
            foreach ($contacts as $contact) {
                # Ensure enrollment for each course where this contact is registered.
                foreach ($DB->get_records('enrol_cvent_registration', array('contactid' => $contact->contactid, 'status' => CV_ACCEPTED)) as $reg) {
                    if ($courseid = $this->ensure_enrolment($reg->registrationid, $user)) {
                        $enrols[$courseid] = true;
                    }
                }
            }
        }
        if ($guestings = $DB->get_records_sql("SELECT g.* FROM {enrol_cvent_reg_guest} g JOIN {enrol_cvent_registration} r ON r.registrationid = g.registrationid WHERE g.emailaddress = ? AND r.status = ?", array($user->username, CV_ACCEPTED))) {
            # Ensure enrollment for each course where this user is a Cvent-guest.
            foreach ($guestings as $guesting) {
                if ($courseid = $this->ensure_enrolment($guesting->registrationid, $user)) {
                    $enrols[$courseid] = true;
                }
            }
        }

        # Unenrol!
        $unenrolaction = $this->get_config('unenrolaction');
        $sql = "SELECT e.*, ue.status AS ustatus
                  FROM {enrol} e
                  JOIN {user_enrolments} ue ON ue.enrolid = e.id
                 WHERE ue.userid = :userid AND e.enrol = :plugin";
        $rs = $DB->get_recordset_sql($sql, array('userid' => $user->id, 'plugin' => CV_NAME));
        foreach ($rs as $instance) {
            if (!$context = get_context_instance(CONTEXT_COURSE, $instance->courseid)) {
                // weird...
                continue;
            }

            if (!empty($enrols[$instance->courseid])) {
                // we want this user enrolled
                continue;
            }

            // deal with enrolments removed from Cvent
            if ($unenrolaction == ENROL_EXT_REMOVED_UNENROL) {
                // unenrol
                $this->unenrol_user($instance, $user->id);

            } else if ($unenrolaction == ENROL_EXT_REMOVED_KEEP) {
                // keep - only adding enrolments

            } else if ($unenrolaction == ENROL_EXT_REMOVED_SUSPEND or $unenrolaction == ENROL_EXT_REMOVED_SUSPENDNOROLES) {
                // disable
                if ($instance->ustatus != ENROL_USER_SUSPENDED) {
                    $DB->set_field('user_enrolments', 'status', ENROL_USER_SUSPENDED, array('enrolid'=>$instance->id, 'userid'=>$user->id));
                }
                if ($unenrolaction == ENROL_EXT_REMOVED_SUSPENDNOROLES) {
                    role_unassign_all(array('contextid'=>$context->id, 'userid'=>$user->id, 'component'=>'enrol_database', 'itemid'=>$instance->id));
                }
            }
        }
        return count(array_keys($enrols));
    }

    /**
     * sync ALL DATA (including enrolments & users) with CVent, cache info locally
     *
     * @param object IGNORED FOR NOW: The role to sync for. If no role is
     * specified, defaults are used.
     * @param bool $latestupdate if null (the default value), behavior is
     * normal, else if 'getall' (the string) none of the GetUpdated() calls are
     * made. This can be used to re-pull records that have been pulled 
     * previously in case any corrections need to be made in local data.
     */
    public function sync_enrolments($latestupdate=null) {
        global $DB;
        error_reporting(E_ALL);

        $this->init_cvent();

        // first, pack the sortorder...
        fix_course_sortorder();

        try {
            $this->sync_events($latestupdate);
            $this->sync_registrations($latestupdate);
            $this->sync_contacts($latestupdate);

            # TODO: make this faster and more efficient
            foreach ($DB->get_records('user') as $user) {
                cvent_safe_print(get_string('set_up_enrolments', 'enrol_cvent', $user->username));
                $count = $this->sync_user_enrolments($user);
                cvent_safe_print(get_string('count', 'enrol_cvent', $count));
            }
        } catch (Exception $e) {
            cvent_safe_print("Exception SOAP info: " . $this->get_soap_trace() . "<br />\n");
            throw $e;
        }
        return true;
    }

    /**
     * Initialize and store the CVent SOAP object; log in to CVent.
     */
    public function init_cvent() {
        if (!enrol_is_enabled('cvent')) {
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
        if (!strlen($this->get_config('account_number')) or !strlen($this->get_config('username')) or !strlen($this->get_config('password'))) {
            debugging('cvent missing account number, username, or password');
            return false;
        }

        $login = new Login(array('AccountNumber' => $this->get_config('account_number'), 'UserName' => $this->get_config('username'), 'Password' => $this->get_config('password')));
        $this->cvent->Login($login);
        return $this->cvent->DescribeGlobal(new DescribeGlobal());
    }

    private function ensure_course($event) {
        global $CFG, $DB;
        if (!$course = $DB->get_record('course', array('idnumber' => $event->eventcode))) {
            cvent_safe_print("Missing course \"$event->eventtitle\" with EventCode $event->eventcode<br />\n");
            if (!$this->get_config('autocreate_courses')) {
                return false;
            }

            require_once("$CFG->dirroot/course/lib.php");
            $categoryid = $DB->get_record_select('course_categories', '', null, 'MIN(id) AS categoryid')->categoryid;
            if (strlen($this->get_config('autocreate_category'))) {
                $categoryid = $this->get_config('autocreate_category');
            }
            cvent_safe_print("Auto-creating course \"$event->eventtitle\" with EventCode $event->eventcode<br />\n");
            $course = create_course((object)array(
                'fullname' => $event->eventtitle,
                # Duplicate eventtitles in CVent cause course creation to 
                # fail... just don't set shortname for now.
                #'shortname' => substr($event->eventtitle, 0, 100),
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
                $DB->update_record('course', $course);
            }
        }
    }

    private function ensure_course_group($course, $groupname) {
        global $DB, $CFG;
        require_once("$CFG->dirroot/group/lib.php");
        static $ids = array();
        $key = "$course->id:$groupname";
        if (!isset($ids[$key])) {
            if ($group = $DB->get_record('groups', array('courseid' => $course->id, 'name' => $groupname))) {
                $ids[$key] = $group->id;
            } else {
                $ids[$key] = groups_create_group((object)array('courseid' => $course->id, 'name' => $groupname));
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

    /**
     * This gets called for every Cvent enrollment ever.
     *
     * @return boolean/integer If false, $user should not be enroled. Else 
     *     a $coure->id for the course in which the user is enroled.
     */
    private function ensure_enrolment($registrationid, $user) {
        global $CFG, $DB;

        static $registrations = array();
        if (!isset($registrations[$registrationid])) {
            $registrations[$registrationid] = $DB->get_record('enrol_cvent_registration', array('registrationid' => $registrationid, 'status' => CV_ACCEPTED));
        }
        $reg = $registrations[$registrationid];

        static $events = array();
        if (!isset($events[$reg->eventid])) {
            $events[$reg->eventid] = $DB->get_record('enrol_cvent_event', array('eventid' => $reg->eventid));
        }
        $event = $events[$reg->eventid];

        # Bail out now if the course doesn't exist yet.
        if (!$course = cvent_course_memoized($event->eventcode)) {
            # The course hasn't been created yet, just fail.
            return false;
        }

        # Bail out now if the event is too far in the future.
        # Just ignore event->timezone. We have no idea from Cvent's spec what
        # to expect in there.
        if (time() < (strtotime($event->eventstartdate) - $this->daysbefore_memoized())) {
            # We aren't yet within enrol_daysbefore of the event
            return false;
        }

        # Bail out now if the event is too far in the past.
        # Just ignore event->timezone. We have no idea from Cvent's spec what
        # to expect in there.
        if (time() > (strtotime($event->eventenddate) + $this->daysafter_memoized())) {
            # We aren't still within enrol_daysafter of the event
            return false;
        }

        $instance = $this->einstances_memoized($course);
        $contact = cvent_contact_memoized($reg->contactid);

        $groupname = $this->generate_groupname($contact);
        $groupid = $this->ensure_course_group($course, $groupname);
        groups_add_member($groupid, $user->id);

        $roleid = $this->roleid_memoized();
        if ($e = $DB->get_record('user_enrolments', array('userid'=>$user->id, 'enrolid'=>$instance->id))) {
            // reenable enrolment when previously disabled enrolment refreshed
            if ($e->status == ENROL_USER_SUSPENDED) {
                $DB->set_field('user_enrolments', 'status', ENROL_USER_ACTIVE, array('enrolid'=>$instance->id, 'userid'=>$user->id));
            }
        } else {
            $this->enrol_user($instance, $user->id, $roleid);
        }
        return $course->id;
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
        global $CFG, $DB;

        # Search for active events that have been updated.
        $filters = array(
            new Filter(array(
                'Field' => 'EventEndDate',
                'Operator' => CvSearchOperatorType::Greater_than_or_Equal_to,
                'Value' => date('m/d/Y'),
            )),
        );

        if (strlen($this->get_config('search_location'))) {
            $filters[] = new Filter(array(
                'Field' => 'Location',
                'Operator' => CvSearchOperatorType::Starts_with,
                'Value' => $this->get_config('search_location'),
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
            if ($tmp = $DB->get_record_sql("SELECT MAX(events_latestupdate) AS latestupdate FROM {enrol_cvent_apicalls_log}")) {
                $latestupdate = gmdate(CV_DATEFORMAT, $tmp->latestupdate);
            }
        }
        $events_latestupdate = time() - 120; # lop of 2 minutes in case of clock skew
        if ($latestupdate != 'getall' and isset($latestupdate)) {
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
        global $DB;
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
                        $event->$key = $val;
                    }
                }
            }
            if ($rec = $DB->get_record('enrol_cvent_event', array('eventid' => $event->eventid))) {
                # Update this record.
                $event->id = $rec->id;
                cvent_safe_print("Updating event ($event->eventid)<br />\n");
                $DB->update_record('enrol_cvent_event', $event);
                $this->ensure_course($event);
            } else {
                # Insert this record.
                cvent_safe_print("Inserting event ($event->eventid)<br />\n");
                $DB->insert_record('enrol_cvent_event', $event);
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
        global $DB;

        if (!$eventids = $DB->get_records_select('enrol_cvent_event', '', null, '', 'eventid')) {
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
            if ($tmp = $DB->get_record_sql("SELECT MAX(registrations_latestupdate) AS latestupdate FROM {enrol_cvent_apicalls_log}")) {
                $latestupdate = gmdate(CV_DATEFORMAT, $tmp->latestupdate);
            }
        }
        $registrations_latestupdate = time() - 120; # lop off 2 minutes in case of clock skew
        if ($latestupdate != 'getall' and isset($latestupdate)) {
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
        global $DB;
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
                        $registration->$key = $val;
                    }
                } elseif ($key == 'guestdetail') {
                    $guestdetails = $val;
                }
            }
            if ($rec = $DB->get_record('enrol_cvent_registration', array('registrationid' => $registration->registrationid))) {
                $registration->id = $rec->id;
                cvent_safe_print("Updating registration ($registration->registrationid)<br />\n");
                $DB->update_record('enrol_cvent_registration', $registration);
            } else {
                cvent_safe_print("Inserting registration ($registration->registrationid)<br />\n");
                $DB->insert_record('enrol_cvent_registration', $registration);
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
        global $DB;
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
                        $guestdetail->$key = $val;
                    }
                }
            }
            if ($rec = $DB->get_record('enrol_cvent_reg_guest', array('guestid' => $guestdetail->guestid))) {
                $guestdetail->id = $rec->id;
                cvent_safe_print("Updating guestdetail ($guestdetail->guestid)<br />\n");
                $DB->update_record('enrol_cvent_reg_guest', $guestdetail);
            } else {
                cvent_safe_print("Inserting guestdetail ($guestdetail->guestid)<br />\n");
                $DB->insert_record('enrol_cvent_reg_guest', $guestdetail);
            }
            $guestdetail->homeaddress1 = $guestdetail->address1;
            $guestdetail->homecity = $guestdetail->state;
            $guestdetail->homestate = $guestdetail->state;
            $guestdetail->homecountrycode = $guestdetail->countrycode;
            $user = cvent_ensure_user($guestdetail);
            # The enrolment will be handled later by setup_enrolments()
        }
    }

    public function get_contacts($latestupdate=null) {
        global $DB;

        if (!$contactids = $DB->get_records_select('enrol_cvent_registration', '', null, '', 'contactid')) {
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
            if ($tmp = $DB->get_record_sql("SELECT MAX(contacts_latestupdate) AS latestupdate FROM {enrol_cvent_apicalls_log}")) {
                $latestupdate = gmdate(CV_DATEFORMAT, $tmp->latestupdate);
            }
        }
        $contacts_latestupdate = time() - 120; # lop off 2 minutes in case of clock skew
        if ($latestupdate != 'getall' and isset($latestupdate)) {
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
        global $DB;
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
                        $contact->$key = $val;
                    }
                } elseif ($key == 'customfielddetail') {
                    # Super-special handling for a custom group name field!
                    foreach ($val as $customfield) {
                        if (strtolower($customfield->FieldName) == 'group name') {
                            $contact->groupname = $customfield->FieldValue;
                        }
                    }
                }
            }
            if ($rec = $DB->get_record('enrol_cvent_contact', array('contactid' => $contact->contactid))) {
                $contact->id = $rec->id;
                cvent_safe_print("Updating contact ($contact->contactid)<br />\n");
                $DB->update_record('enrol_cvent_contact', $contact);
            } else {
                cvent_safe_print("Inserting contact ($contact->contactid)<br />\n");
                $contact->id = $DB->insert_record('enrol_cvent_contact', $contact);
            }
            $user = cvent_ensure_user($contact);
            # Enrolments for this user will be handled later by setup_enrolments()
        }
    }

    /**
     * Synchronize with Cvent if we're configured to do so.
     * @return void
     */
    function cron() {
        global $CFG;
        if (!$this->get_config('cron_frequency')) {
            mtrace(get_string('enrol_cvent_nocron', 'enrol_cvent'));
            return;
        }
        $now = time();
        $untilnextcron = ($this->get_config('lastcron', 0) + ($this->get_config('cron_frequency') * 60)) - $now;
        if ($untilnextcron > 0) {
            # Round to at least one minute.
            $untilnextcron = intval($untilnextcron / 60) + 1;
            mtrace(get_string('enrol_cvent_nocron_now', 'enrol_cvent', $untilnextcron));
            return;
        }
        mtrace(get_string('enrol_cvent_cron_now', 'enrol_cvent'));
        $this->sync_enrolments();
        mtrace('done');
        $this->set_config('lastcron', $now);
    }

    function daysbefore_memoized() {
        static $daysbefore = 0;
        if (!$daysbefore) {
            $daysbefore = ($this->get_config('enrol_daysbefore', CV_DEFAULT_ENROL_DAYSBEFORE) * 24 * 60 * 60);
        }
        return $daysbefore;
    }

    function daysafter_memoized() {
        static $daysafter = 0;
        if (!$daysafter) {
            $daysafter = ($this->get_config('enrol_daysafter', CV_DEFAULT_ENROL_DAYSAFTER) * 24 * 60 * 60);
        }
        return $daysafter;
    }

    function einstances_memoized($course) {
        global $DB;
        static $instances;
        if (!isset($instances[$course->id])) {
            if ($instance = $DB->get_record('enrol', array('courseid'=>$course->id, 'enrol'=>CV_NAME), '*', IGNORE_MULTIPLE)) {
                $instances[$course->id] = $instance;
            } else {
                $enrolid = $this->add_instance($course);
                $instances[$course->id] = $DB->get_record('enrol', array('id'=>$enrolid));
            }
        }
        return $instances[$course->id];
    }

    function roleid_memoized() {
        # We can't use the regular handling of the default value, because the 
        # actual default value is stored in the DB.
        static $roleid = null;

        if (is_null($roleid)) {
            $conf = $this->get_config('roleid');
            if (strlen($conf)) {
                $roleid = $conf;
            } else {
                $role = get_archetype_roles(CV_DEFAULT_ROLE);
                $role = reset($role);
                $roleid = $role->id;
            }
        }
        return $roleid;
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
    global $CFG, $DB;
    if (!strlen($contact->emailaddress)) {
        cvent_safe_print("$contact->lastname, $contact->firstname ($contact->homephone) has no email address, skipping account creation/update<br />\n");
    }
    $user = (object)array(
        'auth' => 'manual',
        'confirmed' => 1,
        'mnethostid' => $CFG->mnet_localhost_id,
        'username' => substr($contact->emailaddress, 0, 100),
        'firstname' => substr($contact->firstname, 0, 100),
        'lastname' => substr($contact->lastname, 0, 100),
        'email' => substr($contact->emailaddress, 0, 100),
        'lang' => 'en_utf8', # default can be changed by user
        'address' => substr($contact->homeaddress1, 0, 70),
        'city' => substr(cvent_citystate_str($contact->homecity, $contact->homestate), 0, 120),
        'country' => substr($contact->homecountrycode, 0, 2),
        'idnumber' => isset($contact->contactid) ? $contact->contactid : '',
    );
    if ($rec = $DB->get_record('user', array('username' => $user->username))) {
        $user->id = $rec->id;
        $DB->update_record('user', $user);
    } else {
        # We need to create this user.
        $user->password = hash_internal_user_password($contact->emailaddress);
        $user->id = $DB->insert_record('user', $user);
        $userpref = $DB->insert_record('user_preferences', (object)array(
            'userid' => $user->id,
            'name' => 'auth_forcepasswordchange',
            'value' => 1,
        ));
    }
    return $user;
}

/**
 * Create a "City, State" string for Moodle's user.city field.
 */
function cvent_citystate_str ($city, $state) {
    if (isset($state) and strlen($state)) {
        return "$city, $state";
    }
    return $city;
}

/**
 * Output the specified string to a secure display. Since cron.php runs as
 * admin, the only safe output ATM is the CLI. If we're not running in the CLI,
 * output goes to error_log().
 *
 * @param $str The string to be printed somewhere.
 */
function cvent_safe_print($str) {
    if (!cvent_verbose_memoized()) {
        return;
    }

    if (CLI_SCRIPT) {
        print $str;
    } else {
        error_log($str);
    }
    return;
}

function cvent_force_sync($latestupdate) {
    global $CFG;
    if (isset($latestupdate)) {
        print "using latestupdate = $latestupdate\n";
    }

    // ensure errors are well explained
    $CFG->debug=E_ALL;
    if (!enrol_is_enabled('cvent')) {
         error_log("CVent enrolment plugin not enabled!");
         die;
    }

    $enrol = new enrol_cvent_plugin();

    if (!CLI_SCRIPT) {
        print "<p><big><big><a target=\"_blank\" href=\"$CFG->wwwroot/enrol/cvent/viewstats.php\">(" . get_string('clicktoseelogafter', 'enrol_cvent') . ")</a></big></big></p>";
    }
    $enrol->sync_enrolments($latestupdate);
}

function cvent_course_memoized($idnumber) {
    global $DB;
    static $courses = array();
    if (!isset($courses[$idnumber])) {
        $courses[$idnumber] = $DB->get_record('course', array('idnumber' => $idnumber));
    }
    return $courses[$idnumber];
}

function cvent_contact_memoized($contactid) {
    global $DB;
    static $contacts = array();
    if (!isset($contacts[$contactid])) {
        $contacts[$contactid] = $DB->get_record('enrol_cvent_contact', array('contactid' => $contactid));
    }
    return $contacts[$contactid];
}

function cvent_verbose_memoized() {
    static $verbose = null;
    if (is_null($verbose)) {
        $verbose = get_config('enrol_cvent', 'verbose');
    }
    return $verbose;
}

?>
