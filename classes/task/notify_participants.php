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
 * Cron task for sending reminder emails
 *
 * @package     mod_ildreqdocs
 * @category    task
 * @copyright   2016 oncampus GmbH, <support@oncampus.de>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 */

defined('MOODLE_INTERNAL') || die();

namespace mod_ildreqdocs\task;

class notify_participants extends \core\task\scheduled_task
{
    public function get_name() {
        // Shown in admin screens.
        return get_string('notify-participants', 'mod_ildreqdocs');
    }

    public function execute() {
        global $CFG;
        require_once($CFG->dirroot . '/mod/ildreqdocs/lib.php');
        ildreqdocs_notify_participants();
    }
}