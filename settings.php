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
 * Define the setting options
 *
 * @package     mod_ildreqdocs
 * @category    admin
 * @copyright   2016 oncampus GmbH, <support@oncampus.de>
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 *
 */

defined('MOODLE_INTERNAL') || die();

$settings->add(new admin_setting_heading(
    'headerconfig',
    get_string('headerconfig', 'mod_ildreqdocs'),
    get_string('descconfig', 'mod_ildreqdocs'), ''
));

$settings->add(new admin_setting_configtextarea(
    'ildreqdocs/infotext',
    get_string('configlabel_infotext', 'mod_ildreqdocs'),
    get_string('configdesc_infotext', 'mod_ildreqdocs'), ''
));

$settings->add(new admin_setting_configtext(
    'ildreqdocs/first_mail_subject',
    get_string('configlabel_first_mail_subject', 'mod_ildreqdocs'),
    get_string('configdesc_first_mail_subject', 'mod_ildreqdocs'), ''
));

$settings->add(new admin_setting_configtextarea(
    'ildreqdocs/first_mail_content',
    get_string('configlabel_first_mail_content', 'mod_ildreqdocs'),
    get_string('configdesc_first_mail_content', 'mod_ildreqdocs'), ''
));

$settings->add(new admin_setting_configtext(
    'ildreqdocs/second_mail_subject',
    get_string('configlabel_second_mail_subject', 'mod_ildreqdocs'),
    get_string('configdesc_second_mail_subject', 'mod_ildreqdocs'), ''
));

$settings->add(new admin_setting_configtextarea(
    'ildreqdocs/second_mail_content',
    get_string('configlabel_second_mail_content', 'mod_ildreqdocs'),
    get_string('configdesc_second_mail_content', 'mod_ildreqdocs'), ''
));

$settings->add(new admin_setting_configtext(
    'ildreqdocs/responsible_mail_subject',
    get_string('configlabel_responsible_mail_subject', 'mod_ildreqdocs'),
    get_string('configdesc_responsible_mail_subject', 'mod_ildreqdocs'), ''
));

$settings->add(new admin_setting_configtextarea(
    'ildreqdocs/responsible_mail_content',
    get_string('configlabel_responsible_mail_content', 'mod_ildreqdocs'),
    get_string('configdesc_responsible_mail_content', 'mod_ildreqdocs'), ''
));

$settings->add(new admin_setting_configtext(
    'ildreqdocs/overview_mail_subject',
    get_string('configlabel_overview_mail_subject', 'mod_ildreqdocs'),
    get_string('configdesc_overview_mail_subject', 'mod_ildreqdocs'), ''
));

$settings->add(new admin_setting_configtextarea(
    'ildreqdocs/overview_mail_content',
    get_string('configlabel_overview_mail_content', 'mod_ildreqdocs'),
    get_string('configdesc_overview_mail_content', 'mod_ildreqdocs'), ''
));