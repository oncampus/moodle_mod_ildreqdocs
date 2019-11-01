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

defined('MOODLE_INTERNAL') || die;

/**
 * @param $feature
 * @return bool|null
 */
function ildreqdocs_supports($feature) {
    switch ($feature) {
        case FEATURE_MOD_INTRO:
            return false;
        case FEATURE_COMPLETION_TRACKS_VIEWS:
            return true;
        case FEATURE_COMPLETION_HAS_RULES:
            return false;
        case FEATURE_GRADE_HAS_GRADE:
            return false;
        case FEATURE_BACKUP_MOODLE2:
            return false;
        case FEATURE_SHOW_DESCRIPTION:
            return false;
        default:
            return null;
    }
}

/**
 * @param $data
 * @return mixed
 */
function ildreqdocs_add_instance($data) {
    global $CFG, $DB;
    require_once("$CFG->dirroot/mod/ildreqdocs/locallib.php");

    $data->timemodified = time();
    $cmid = $data->coursemodule;
    $data->id = $DB->insert_record('ildreqdocs', $data);

    $DB->set_field('course_modules', 'instance', $data->id, array('id' => $cmid));
    ildreqdocs_set_mainfile($data);
    return $data->id;
}

/**
 * @param $data
 * @return bool
 */
function ildreqdocs_update_instance($data) {
    global $CFG, $DB;
    require_once("$CFG->dirroot/mod/ildreqdocs/locallib.php");

    $data->timemodified = time();
    $data->id = $data->instance;

    $DB->update_record('ildreqdocs', $data);
    ildreqdocs_set_mainfile($data);

    return true;
}

/**
 * @param $id
 * @return bool
 */
function ildreqdocs_delete_instance($id) {
    global $DB;

    if (!$ildreqdocs = $DB->get_record('ildreqdocs', array('id' => $id))) {
        return false;
    }

    $DB->delete_records('ildreqdocs', array('id' => $ildreqdocs->id));

    return true;
}

/**
 * Given a course_module object, this function returns any
 * "extra" information that may be needed when printing
 * this activity in a course listing.
 *
 * See {@link get_array_of_activities()} in course/lib.php
 *
 * @param stdClass $coursemodule
 * @return cached_cm_info info
 */
function ildreqdocs_get_coursemodule_info($coursemodule) {
    global $CFG, $DB;
    require_once("$CFG->libdir/filelib.php");
    require_once("$CFG->dirroot/mod/ildreqdocs/locallib.php");
    require_once($CFG->libdir . '/completionlib.php');

    $context = context_module::instance($coursemodule->id);

    if (!$ildreqdocs = $DB->get_record('ildreqdocs', array('id' => $coursemodule->instance),
        'id, name, intro, introformat')
    ) {
        return null;
    }

    $info = new cached_cm_info();
    $info->name = $ildreqdocs->name;
    if ($coursemodule->showdescription) {
        // Convert intro to html. Do not filter cached version, filters run at display time.
        $info->content = format_module_intro('ildreqdocs', $ildreqdocs, $coursemodule->id, false);
    }

    $fs = get_file_storage();
    // TODO: this is not very efficient!!
    $files = $fs->get_area_files($context->id, 'mod_ildreqdocs', 'content', 0, 'sortorder DESC, id ASC', false);
    if (count($files) >= 1) {
        $mainfile = reset($files);
        $info->icon = file_file_icon($mainfile, 24);
        $ildreqdocs->mainfile = $mainfile->get_filename();
    }

    $fullurl = "$CFG->wwwroot/mod/ildreqdocs/view.php?id=$coursemodule->id&amp;redirect=1";
    $info->onclick = "window.open('$fullurl'); return false;";

    return $info;
}

/**
 * Lists all browsable file areas
 *
 * @package  mod_ildreqdocs
 * @category files
 * @param stdClass $course course object
 * @param stdClass $cm course module object
 * @param stdClass $context context object
 * @return array
 */
function ildreqdocs_get_file_areas($course, $cm, $context) {
    $areas = array();
    $areas['content'] = get_string('resourcecontent', 'resource');
    return $areas;
}

/**
 * File browsing support for resource module content area.
 *
 * @package  mod_ildreqdocs
 * @category files
 * @param stdClass $browser file browser instance
 * @param stdClass $areas file areas
 * @param stdClass $course course object
 * @param stdClass $cm course module object
 * @param stdClass $context context object
 * @param string $filearea file area
 * @param int $itemid item ID
 * @param string $filepath file path
 * @param string $filename file name
 * @return file_info instance or null if not found
 */
function ildreqdocs_get_file_info($browser, $areas, $course, $cm, $context, $filearea, $itemid, $filepath, $filename) {
    global $CFG;

    if (!has_capability('moodle/course:managefiles', $context)) {
        // Students can not peak here!
        return null;
    }

    $fs = get_file_storage();

    if ($filearea === 'content') {
        $filepath = is_null($filepath) ? '/' : $filepath;
        $filename = is_null($filename) ? '.' : $filename;

        $urlbase = $CFG->wwwroot . '/pluginfile.php';
        if (!$storedfile = $fs->get_file($context->id, 'mod_ildreqdocs', 'content', 0, $filepath, $filename)) {
            if ($filepath === '/' and $filename === '.') {
                $storedfile = new virtual_root_file($context->id, 'mod_ildreqdocs', 'content', 0);
            } else {
                // Not found.
                return null;
            }
        }
        require_once("$CFG->dirroot/mod/ildreqdocs/locallib.php");
        return new ildreqdocs_content_file_info($browser, $context, $storedfile, $urlbase, $areas[$filearea],
            true, true, true, false);
    }

    // Note: resource_intro handled in file_browser automatically.

    return null;
}

/**
 * Serves the ildreqdocs files.
 *
 * @package  mod_ildreqdocs
 * @category files
 * @param stdClass $course course object
 * @param stdClass $cm course module object
 * @param stdClass $context context object
 * @param string $filearea file area
 * @param array $args extra arguments
 * @param bool $forcedownload whether or not force download
 * @param array $options additional options affecting the file serving
 * @return bool false if file not found, does not return if found - just send the file
 */
function ildreqdocs_pluginfile($course, $cm, $context, $filearea, $args, $forcedownload, array $options = array()) {
    if ($context->contextlevel != CONTEXT_MODULE) {
        return false;
    }

    require_course_login($course, true, $cm);
    if (!has_capability('mod/ildreqdocs:view', $context)) {
        return false;
    }

    if ($filearea !== 'content') {
        // Intro is handled automatically in pluginfile.php.
        return false;
    }

    // Ignore revision - designed to prevent caching problems only.
    array_shift($args);

    $fs = get_file_storage();
    $relativepath = implode('/', $args);
    $fullpath = rtrim("/$context->id/mod_ildreqdocs/$filearea/0/$relativepath", '/');
    do {
        if (!$file = $fs->get_file_by_hash(sha1($fullpath))) {
            if ($fs->get_file_by_hash(sha1("$fullpath/."))) {
                if ($file = $fs->get_file_by_hash(sha1("$fullpath/index.htm"))) {
                    break;
                }
                if ($file = $fs->get_file_by_hash(sha1("$fullpath/index.html"))) {
                    break;
                }
                if ($file = $fs->get_file_by_hash(sha1("$fullpath/Default.htm"))) {
                    break;
                }
            }
        }
    } while (false);

    // Finally send the file.
    send_stored_file($file, null, 0, 0, $options);
}

/**
 * Mark the activity completed (if required) and trigger the course_module_viewed event.
 *
 * @param  stdClass $ildreqdocs resource object
 * @param  stdClass $course course object
 * @param  stdClass $cm course module object
 * @param  stdClass $context context object
 * @since Moodle 3.0
 */
function ildreqdocs_view($ildreqdocs, $course, $cm, $context) {

    // Trigger course_module_viewed event.
    $params = array(
        'context' => $context,
        'objectid' => $ildreqdocs->id
    );

    $event = \mod_ildreqdocs\event\course_module_viewed::create($params);
    $event->add_record_snapshot('course_modules', $cm);
    $event->add_record_snapshot('course', $course);
    $event->add_record_snapshot('ildreqdocs', $ildreqdocs);
    $event->trigger();

    // Completion.
    $completion = new completion_info($course);
    $completion->set_module_viewed($cm);
}

/**
 * Check the requirements and send mail if needed
 */
function ildreqdocs_notify_participants() {
    global $DB;

    $reqdocs = $DB->get_records('ildreqdocs');
    $module = $DB->get_record('modules', array('name' => 'ildreqdocs'));

    /* each required document */
    foreach ($reqdocs as $doc) {
        $now = time();
        $context = context_course::instance($doc->course);

        /* get course_module from document */
        $coursemodule = $DB->get_record('course_modules', array('course' => $doc->course, 'module' => $module->id,
            'instance' => $doc->id));

        // Check group conditions.
        if (isset($coursemodule->availability) && $coursemodule->availability != null) {
            $participants = array();
            $availability = json_decode($coursemodule->availability);

            foreach ($availability->c as $condition) {
                if ($condition->type == 'group') {
                    $groupusers = $DB->get_records('groups_members', array('groupid' => $condition->id));

                    foreach ($groupusers as $groupuser) {
                        $user = $DB->get_record('user', array('id' => $groupuser->userid));

                        array_push($participants, $user);
                    }
                }
            }
        } else {
            $participants = get_enrolled_users($context, 'mod/ildreqdocs:participant');
        }

        // Get enrolled teacher.
        $responsible = get_enrolled_users($context, 'mod/ildreqdocs:responsible');

        if ($coursemodule->visible == 1) {
            if ($now >= $doc->startdate && ($doc->enddate == 0 || $now < $doc->enddate)) {
                foreach ($participants as $participant) {
                    $completion = $DB->get_record('course_modules_completion', array('coursemoduleid' => $coursemodule->id,
                        'userid' => $participant->id));

                    if (!$completion || $completion->completionstate != 1) {
                        ildreqdocs_notify($participant, $responsible, $doc, $coursemodule->id);
                    }
                }
            }

            /* send overview mail */
            if ($now > $doc->enddate && $doc->enddate != 0) {
                ildreqdocs_send_overview($responsible, $doc, $coursemodule->id);
            }
        }
    }
}

/**
 * Send overview mail
 *
 * @param $responsible
 * @param $doc
 * @param $cmid
 */
function ildreqdocs_send_overview($responsible, $doc, $cmid) {
    global $DB;

    if (empty($doc->overviewmailsubject)) {
        $subject = ildreqdocs_parse_placeholder(get_config('ildreqdocs', 'overview_mail_subject'), $doc);
    } else {
        $subject = ildreqdocs_parse_placeholder($doc->overviewmailsubject, $doc);
    }

    if (empty($doc->overviewmailcontent)) {
        $content = ildreqdocs_parse_placeholder(get_config('ildreqdocs', 'overview_mail_content'), $doc);
    } else {
        $content = ildreqdocs_parse_placeholder($doc->overviewmailcontent, $doc);
    }

    foreach ($responsible as $userto) {
        $userpref = $DB->get_record('user_preferences', array('userid' => $userto->id,
            'name' => 'ildreqdocs_overview_sent_' . $cmid));

        if (!$userpref) {
            $sent = ildreqdocs_send_message($userto, $subject, $content);

            if ($sent) {
                $record = new stdClass();
                $record->userid = $userto->id;
                $record->name = 'ildreqdocs_overview_sent_' . $cmid;
                $record->value = 1;
                $DB->insert_record('user_preferences', $record, false);
            }
        }
    }
}

/**
 * Check trys and notify participants
 *
 * @param $participant
 * @param $responsible
 * @param $doc
 * @param $cmid
 */
function ildreqdocs_notify($participant, $responsible, $doc, $cmid) {
    global $DB;

    $userpref = $DB->get_record('user_preferences', array('userid' => $participant->id,
        'name' => 'ildreqdocs_notification_' . $cmid));

    // If participant has preference entry.
    if ($userpref) {
        $pref = unserialize($userpref->value);

        // Check if attempt is lower then max. notifications.
        if ($pref['attempt'] < $doc->maxnotifications) {
            $lasttry = $pref['last_try'];
            $nexttry = 0;

            switch ($doc->notificationperiod) {
                case 'weekly':
                    $nexttry = strtotime('+1 week', $lasttry);
                    break;
                case 'fortnight':
                    $nexttry = strtotime('+2 weeks', $lasttry);
                    break;
                case 'monthly':
                    $nexttry = strtotime('+1 month', $lasttry);
                    break;
            }

            if (time() >= $nexttry) {
                if (empty($doc->secondmailsubject)) {
                    $subject = ildreqdocs_parse_placeholder(get_config('ildreqdocs', 'second_mail_subject'), $doc);
                } else {
                    $subject = ildreqdocs_parse_placeholder($doc->secondmailsubject, $doc);
                }

                if (empty($doc->secondmailcontent)) {
                    $content = ildreqdocs_parse_placeholder(get_config('ildreqdocs', 'second_mail_content'), $doc, $participant);
                } else {
                    $content = ildreqdocs_parse_placeholder($doc->secondmailcontent, $doc, $participant);
                }

                $sent = ildreqdocs_send_message($participant, $subject, $content);

                if ($sent) {
                    $attempt = $pref['attempt'];

                    $record = new stdClass();
                    $record->id = $userpref->id;
                    $record->userid = $participant->id;
                    $record->name = 'ildreqdocs_notification_' . $cmid;
                    $record->value = serialize(array('last_try' => time(), 'attempt' => ($attempt + 1),
                        'responsible_notified' => 0));
                    $DB->update_record('user_preferences', $record, false);
                }
            }
            // Reached max. notifications, notify responsible.
        } else {
            if ($pref['responsible_notified'] == '0') {
                if (empty($doc->responsiblewmailsubject)) {
                    $subject = ildreqdocs_parse_placeholder(get_config('ildreqdocs', 'responsible_mail_subject'), $doc);
                } else {
                    $subject = ildreqdocs_parse_placeholder($doc->responsiblemailsubject, $doc);
                }

                if (empty($doc->responsiblewmailcontent)) {
                    $content = ildreqdocs_parse_placeholder(get_config('ildreqdocs', 'responsible_mail_content'),
                        $doc, $participant);
                } else {
                    $content = ildreqdocs_parse_placeholder($doc->responsiblemailcontent, $doc, $participant);
                }

                $attempt = $pref['attempt'];

                $record = new stdClass();
                $record->id = $userpref->id;
                $record->userid = $participant->id;
                $record->name = 'ildreqdocs_notification_' . $cmid;
                $record->value = serialize(array('last_try' => time(), 'attempt' => $attempt, 'responsible_notified' => 1));
                $DB->update_record('user_preferences', $record, false);
            }
        }
        // Participant has no preferences, send first mail.
    } else {
        if (empty($doc->firstmailsubject)) {
            $subject = ildreqdocs_parse_placeholder(get_config('ildreqdocs', 'first_mail_subject'), $doc);
        } else {
            $subject = ildreqdocs_parse_placeholder($doc->firstmailsubject, $doc);
        }

        if (empty($doc->firstmailcontent)) {
            $content = ildreqdocs_parse_placeholder(get_config('ildreqdocs', 'first_mail_content'), $doc, $participant);
        } else {
            $content = ildreqdocs_parse_placeholder($doc->firstmailcontent, $doc, $participant);
        }

        $sent = ildreqdocs_send_message($participant, $subject, $content);

        if ($sent) {
            $record = new stdClass();
            $record->userid = $participant->id;
            $record->name = 'ildreqdocs_notification_' . $cmid;
            $record->value = serialize(array('last_try' => time(), 'attempt' => 1, 'responsible_notified' => 0));
            $DB->insert_record('user_preferences', $record, false);
        }
    }
}

/**
 * Send email with given template
 *
 * @param $recipient
 * @param $subject
 * @param $content
 * @return mixed
 */
function ildreqdocs_send_message($recipient, $subject, $content) {
    global $USER;

    $USER->firstname = 'Lernraum';
    $USER->lastname = 'FH-Lübeck';

    $message = new \core\message\message();
    $message->component = 'mod_ildreqdocs';
    $message->name = 'notify';
    $message->userfrom = $USER;
    $message->userto = $recipient;
    $message->subject = $subject;
    $message->fullmessage = $content;
    $message->fullmessageformat = FORMAT_MARKDOWN;
    $message->fullmessagehtml = '<p>' . $content . '</p>';
    $message->smallmessage = '';
    $message->notification = '0';
    $message->replyto = 'lernraum-team@fh-luebeck.de';

    $messageid = message_send($message);

    return $messageid;
}

/**
 * Parse placeholders - add more placeholder if required
 *
 * @param $text
 * @param $doc
 * @param null $participant
 * @return mixed
 */
function ildreqdocs_parse_placeholder($text, $doc, $participant = null) {
    $courselink = new moodle_url('/course/view.php', array('id' => $doc->course));
    $overviewlink = new moodle_url('/report/progress/index.php', array('course' => $doc->course));

    if ($participant == null) {
        $placeholder = array('{DOCNAME}', '{COURSELINK}', '{OVERVIEWLINK}');
        $items = array($doc->name, $courselink, $overviewlink);
    } else {
        $placeholder = array('{FIRSTNAME}', '{LASTNAME}', '{DOCNAME}', '{COURSELINK}', '{OVERVIEWLINK}');
        $items = array($participant->firstname, $participant->lastname, $doc->name, $courselink, $overviewlink);
    }

    $text = str_replace($placeholder, $items, $text);

    return $text;
}

/**
 * Prints infotext beneath the activity on course page
 *
 * @param cm_info $cm
 */
function ildreqdocs_cm_info_dynamic(cm_info $cm) {
    global $PAGE, $CFG, $DB;

    $PAGE->requires->jquery();
    $PAGE->requires->js(new moodle_url($CFG->httpswwwroot . '/mod/ildreqdocs/js/ildreqdocs.js'), false);

    $cmr = $cm->get_course_module_record();
    $ildreqdoc = $DB->get_record('ildreqdocs', array('id' => $cmr->instance));

    if (empty($ildreqdoc->infotext)) {
        $cm->set_content(get_config('ildreqdocs', 'infotext'));
    } else {
        $cm->set_content($ildreqdoc->infotext);
    }
}