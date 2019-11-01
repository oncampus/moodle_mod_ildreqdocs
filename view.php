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
 *
 * @package     mod_ildreqdocs
 * @copyright   2016 oncampus GmbH, <support@oncampus.de>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 */

require('../../config.php');
require_once($CFG->dirroot . '/mod/ildreqdocs/lib.php');
require_once($CFG->libdir . '/completionlib.php');

$id = optional_param('id', 0, PARAM_INT); // Course Module ID.
$redirect = optional_param('redirect', 0, PARAM_BOOL);

if (!$cm = get_coursemodule_from_id('ildreqdocs', $id)) {
    print_error('Course Module ID was incorrect'); // NOTE this is invalid use of print_error, must be a lang string id.
}

if (!$course = $DB->get_record('course', array('id' => $cm->course))) {
    print_error('course is misconfigured');  // NOTE As above.
}

$ildreqdocs = $DB->get_record('ildreqdocs', array('id' => $cm->instance), '*', MUST_EXIST);

require_course_login($course, true, $cm);
$context = context_module::instance($cm->id);
require_capability('mod/ildreqdocs:view', $context);

// Completion and trigger events.
ildreqdocs_view($ildreqdocs, $course, $cm, $context);

$PAGE->set_url('/mod/ildreqdocs/view.php', array('id' => $cm->id));

$fs = get_file_storage();
// TODO: this is not very efficient!!
$files = $fs->get_area_files($context->id, 'mod_ildreqdocs', 'content', 0, 'sortorder DESC, id ASC', false);
if (count($files) < 1) {
    echo $OUTPUT->notification(get_string('filenotfound', 'ildreqdocs'));
    echo $OUTPUT->footer();
    die;
} else {
    $file = reset($files);
    unset($files);
}

$ildreqdocs->mainfile = $file->get_filename();

if (strpos(get_local_referer(false), 'modedit.php') === false) {
    $redirect = true;
}

// Don't redirect teachers, otherwise they can not access course or module settings.
if ($redirect && !course_get_format($course)->has_view_page() &&
    (has_capability('moodle/course:manageactivities', $context) ||
        has_capability('moodle/course:update', context_course::instance($course->id)))
) {
    $redirect = false;
}

if ($redirect) {
    // Coming from course page or url index page this redirect trick solves caching problems when tracking views ;-).
    $path = '/' . $context->id . '/mod_ildreqdocs/content' . $file->get_filepath() . '0/' . $file->get_filename();
    $fullurl = moodle_url::make_file_url('/pluginfile.php', $path, 'false');
    redirect($fullurl);
}
