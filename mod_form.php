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
 * ildreqdocs configuration form
 *
 * @package     mod_ildreqdocs
 * @copyright   2016 oncampus GmbH, <support@oncampus.de>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 */

defined('MOODLE_INTERNAL') || die();

require_once($CFG->dirroot . '/course/moodleform_mod.php');
require_once($CFG->libdir . '/filelib.php');

class mod_ildreqdocs_mod_form extends moodleform_mod
{
    public function definition() {

        $mform =& $this->_form;

        // Header and name.
        $mform->addElement('header', 'general', get_string('general', 'form'));
        $mform->addElement('text', 'name', get_string('name'), array('size' => '48'));
        $mform->setType('name', PARAM_TEXT);
        $mform->addRule('name', null, 'required', null, 'client');
        $mform->addRule('name', get_string('maximumchars', '', 255), 'maxlength', 255, 'client');

        // Filemanager options.
        $filemanageroptions = array();
        $filemanageroptions['accepted_types'] = '*';
        $filemanageroptions['maxbytes'] = 0;
        $filemanageroptions['maxfiles'] = -1;
        $filemanageroptions['mainfile'] = true;

        // Filemanager.
        $mform->addElement('filemanager', 'files', get_string('selectfiles'), null, $filemanageroptions);
        $mform->addRule('files', null, 'required', null, 'client');

        // Startdate.
        $mform->addElement('date_time_selector', 'startdate', get_string('from'), array('startyear' => 2016));
        $mform->addRule('startdate', null, 'required', null, 'client');

        // Enddate.
        $mform->addElement('date_time_selector', 'enddate', get_string('to'), array('startyear' => 2016, 'optional' => true));

        // Notificationperiod.
        $options = array('weekly' => get_string('weekly', 'ildreqdocs'), 'fortnight' => get_string('fortnight', 'ildreqdocs'),
            'monthly' => get_string('monthly', 'ildreqdocs'));
        $mform->addElement('select', 'notificationperiod', get_string('notificationperiod', 'ildreqdocs'), $options);
        $mform->setDefault('notificationperiod', 0);
        $mform->addRule('notificationperiod', null, 'required', null, 'client');

        // Maximal notifications.
        $mform->addElement('text', 'maxnotifications', get_string('maxnotifications', 'ildreqdocs'), array('size' => 3));
        $mform->setType('maxnotifications', PARAM_INT);
        $mform->addRule('maxnotifications', null, 'required', null, 'client');

        // Information text group.
        $mform->addElement('header', 'infotextgroup', get_string('configdesc_infotext', 'ildreqdocs'));
        $mform->addElement('textarea', 'infotext', get_string('configlabel_infotext', 'ildreqdocs'), 'rows="10"');
        $mform->setDefault('infotext', get_config('ildreqdocs', 'infotext'));

        // First mail group.
        $mform->addElement('header', 'firstmailgroup', get_string('firstmailgroup', 'ildreqdocs'));
        $mform->addElement('text', 'firstmailsubject', get_string('configlabel_first_mail_subject', 'ildreqdocs'), 'size="150"');
        $mform->setDefault('firstmailsubject', get_config('ildreqdocs', 'first_mail_subject'));
        $mform->addHelpButton('firstmailsubject', 'mailsubject', 'mod_ildreqdocs');
        $mform->addElement('textarea', 'firstmailcontent', get_string('configlabel_first_mail_content', 'ildreqdocs'), 'rows="10"');
        $mform->setDefault('firstmailcontent', get_config('ildreqdocs', 'first_mail_content'));
        $mform->addHelpButton('firstmailcontent', 'mailcontent', 'mod_ildreqdocs');

        // Second mail group.
        $mform->addElement('header', 'secondmailgroup', get_string('secondmailgroup', 'ildreqdocs'));
        $mform->addElement('text', 'secondmailsubject', get_string('configlabel_second_mail_subject',
            'ildreqdocs'), 'size="150"');
        $mform->setDefault('secondmailsubject', get_config('ildreqdocs', 'second_mail_subject'));
        $mform->addHelpButton('secondmailsubject', 'mailsubject', 'mod_ildreqdocs');
        $mform->addElement('textarea', 'secondmailcontent', get_string('configlabel_second_mail_content',
            'ildreqdocs'), 'rows="10"');
        $mform->setDefault('secondmailcontent', get_config('ildreqdocs', 'second_mail_content'));
        $mform->addHelpButton('secondmailcontent', 'mailcontent', 'mod_ildreqdocs');

        // Responsible mail group.
        $mform->addElement('header', 'responsiblemailgroup', get_string('responsiblemailgroup', 'ildreqdocs'));
        $mform->addElement('text', 'responsiblemailsubject', get_string('configlabel_responsible_mail_subject',
            'ildreqdocs'), 'size="150"');
        $mform->setDefault('responsiblemailsubject', get_config('ildreqdocs', 'responsible_mail_subject'));
        $mform->addHelpButton('responsiblemailsubject', 'mailsubject', 'mod_ildreqdocs');
        $mform->addElement('textarea', 'responsiblemailcontent', get_string('configlabel_responsible_mail_content',
            'ildreqdocs'), 'rows="10"');
        $mform->setDefault('responsiblemailcontent', get_config('ildreqdocs', 'responsible_mail_content'));
        $mform->addHelpButton('responsiblemailcontent', 'responsiblemailcontent', 'mod_ildreqdocs');

        // Overview mail group.
        $mform->addElement('header', 'overviewmailgroup', get_string('overviewmailgroup', 'ildreqdocs'));
        $mform->addElement('text', 'overviewmailsubject', get_string('configlabel_overview_mail_subject', 'ildreqdocs'),
            'size="150"');
        $mform->setDefault('overviewmailsubject', get_config('ildreqdocs', 'overview_mail_subject'));
        $mform->addHelpButton('overviewmailsubject', 'mailsubject', 'mod_ildreqdocs');
        $mform->addElement('textarea', 'overviewmailcontent', get_string('configlabel_overview_mail_content', 'ildreqdocs'),
            'rows="10"');
        $mform->setDefault('overviewmailcontent', get_config('ildreqdocs', 'overview_mail_content'));
        $mform->addHelpButton('overviewmailcontent', 'overviewmailcontent', 'mod_ildreqdocs');

        $this->standard_coursemodule_elements();

        $this->add_action_buttons();

    }

    public function data_preprocessing(&$defaultvalues) {
        if ($this->current->instance) {
            $draftitemid = file_get_submitted_draft_itemid('files');
            file_prepare_draft_area($draftitemid, $this->context->id, 'mod_ildreqdocs', 'content', 0, array('subdirs' => true));
            $defaultvalues['files'] = $draftitemid;
        }
    }

    public function validation($data, $files) {
        global $USER;

        $errors = parent::validation($data, $files);

        $usercontext = context_user::instance($USER->id);
        $fs = get_file_storage();
        if (!$files = $fs->get_area_files($usercontext->id, 'user', 'draft', $data['files'], 'sortorder, id', false)) {
            $errors['files'] = get_string('required');
            return $errors;
        }
        if (count($files) == 1) {
            // No need to select main file if only one picked.
            return $errors;
        } else if (count($files) > 1) {
            $mainfile = false;
            foreach ($files as $file) {
                if ($file->get_sortorder() == 1) {
                    $mainfile = true;
                    break;
                }
            }
            // Set a default main file.
            if (!$mainfile) {
                $file = reset($files);
                file_set_sortorder($file->get_contextid(), $file->get_component(), $file->get_filearea(), $file->get_itemid(),
                    $file->get_filepath(), $file->get_filename(), 1);
            }
        }
        return $errors;
    }
}
