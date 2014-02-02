<?php

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

/**
 * Cvent enrolment plugin settings and presets.
 *
 * @package    enrol
 * @subpackage cvent
 * @copyright  2012 Matt Oquist {@link http://majen.net}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();
require_once(dirname(__FILE__) . '/defines.php');
require_once(dirname(dirname(dirname(__FILE__))) . '/course/lib.php');

if ($ADMIN->fulltree) {

    //--- general settings -----------------------------------------------------------------------------------
    $settings->add(new admin_setting_heading('enrol_cvent_settings', '', get_string('pluginname_desc', 'enrol_cvent')));


    //--- enrol instance defaults ----------------------------------------------------------------------------
    $settings->add(new admin_setting_heading('cvent_heading',
        get_string('server_settings', 'enrol_cvent'), get_string('view_stats', 'enrol_cvent', "$CFG->wwwroot/enrol/cvent/viewstats.php")));

    $settings->add(new admin_setting_configtext('enrol_cvent/account_number',
        get_string('account_number', 'enrol_cvent'), get_string('account_number_desc', 'enrol_cvent'), '', PARAM_ALPHANUM));

    $settings->add(new admin_setting_configtext('enrol_cvent/username',
        get_string('username', 'enrol_cvent'), get_string('username_desc', 'enrol_cvent'), '', PARAM_TEXT));

    $settings->add(new admin_setting_configpasswordunmask('enrol_cvent/password',
        get_string('password', 'enrol_cvent'), get_string('password_desc', 'enrol_cvent'), '', PARAM_TEXT));

    $settings->add(new admin_setting_configtext('enrol_cvent/enrol_daysbefore',
        get_string('enrol_daysbefore', 'enrol_cvent'), get_string('enrol_daysbefore_desc', 'enrol_cvent'), CV_DEFAULT_ENROL_DAYSBEFORE, PARAM_INT));

    $settings->add(new admin_setting_configtext('enrol_cvent/enrol_daysafter',
        get_string('enrol_daysafter', 'enrol_cvent'), get_string('enrol_daysafter_desc', 'enrol_cvent'), CV_DEFAULT_ENROL_DAYSAFTER, PARAM_INT));

    $settings->add(new admin_setting_configtext('enrol_cvent/search_location',
        get_string('search_location', 'enrol_cvent'), get_string('search_location_desc', 'enrol_cvent'), '', PARAM_TEXT));

    $options = get_default_enrol_roles(get_context_instance(CONTEXT_SYSTEM));
    $default = get_archetype_roles(CV_DEFAULT_ROLE);
    $default = reset($default);
    $settings->add(new admin_setting_configselect('enrol_cvent/roleid', get_string('defaultrole', 'role'), get_string('defaultrole_desc', 'enrol_cvent'), $default->id, $options));

    $options = array(ENROL_EXT_REMOVED_UNENROL        => get_string('extremovedunenrol', 'enrol'),
                     ENROL_EXT_REMOVED_KEEP           => get_string('extremovedkeep', 'enrol'),
                     ENROL_EXT_REMOVED_SUSPEND        => get_string('extremovedsuspend', 'enrol'),
                     ENROL_EXT_REMOVED_SUSPENDNOROLES => get_string('extremovedsuspendnoroles', 'enrol'));
    $settings->add(new admin_setting_configselect('enrol_cvent/unenrolaction', get_string('extremovedaction', 'enrol'), get_string('extremovedaction_help', 'enrol'), ENROL_EXT_REMOVED_UNENROL, $options));

    $options = array(true => get_string('yes'), false => get_string('no'));
    $settings->add(new admin_setting_configselect('enrol_cvent/autocreate_courses',
        get_string('autocreate_courses', 'enrol_cvent'), get_string('autocreate_courses_desc', 'enrol_cvent'), ENROL_INSTANCE_ENABLED, $options));

    $options = array();
    $trash = array();
    make_categories_list($options, $trash);
    $settings->add(new admin_setting_configselect('enrol_cvent/autocreate_category',
        get_string('autocreate_category', 'enrol_cvent'), get_string('autocreate_category_desc', 'enrol_cvent'), '', $options));

    $settings->add(new admin_setting_configtext('enrol_cvent/cron_frequency',
        get_string('cron_frequency', 'enrol_cvent'), get_string('cron_frequency_desc', 'enrol_cvent'), 0, PARAM_INT));

}

