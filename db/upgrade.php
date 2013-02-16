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
 * Cvent enrolment plugin upgrade.
 *
 * @package    enrol_cvent
 * @copyright  2013 Matt Oquist {@link http://majen.net}
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();
function xmldb_enrol_cvent_upgrade($oldversion) {
    global $CFG, $DB;

    $dbman = $DB->get_manager();

    if ($oldversion < 2013021600) {

        // Define table enrol_cvent_registration_guest to be renamed to enrol_cvent_reg_guest
        $table = new xmldb_table('enrol_cvent_registration_guest');

        // Launch rename table for enrol_cvent_registration_guest
        $dbman->rename_table($table, 'enrol_cvent_reg_guest');

        // cvent savepoint reached
        upgrade_plugin_savepoint(true, 2013021600, 'enrol', 'cvent');
    }

    return true;
}
