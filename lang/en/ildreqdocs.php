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

defined('MOODLE_INTERNAL') || die();

$string['modulename'] = 'Required document';
$string['pluginname'] = 'Required document';
$string['pluginadministration'] = 'Required document';
$string['modulenameplural'] = 'Required documents';
$string['ildreqdocs:addinstance'] = 'Add new required document';

$string['headerconfig'] = 'Required document e-mail configuration';
$string['descconfig'] = 'Global e-mail template configuration for required documents';
$string['configlabel_infotext'] = 'Information text';
$string['configdesc_infotext'] = 'Information text beneath the activity';

$string['mailsubject'] = 'Subject';
$string['mailsubject_help'] = '<b>Placeholder:</b><br/>{DOCNAME} - Documentname';
$string['mailcontent'] = 'Content';
$string['mailcontent_help'] = '<b>Placeholder:</b><br/>{DOCNAME} - Documentname<br/>{FIRSTNAME} - Firstname<br/>{LASTNAME} - Lastanem<br/>{COURSELINK} - Courselink';
$string['responsiblewmailcontent'] = 'Content';
$string['responsiblemailcontent_help'] = '<b>Placholder:</b><br/>{DOCNAME} - Documentname<br/>{FIRSTNAME} - Firstname<br/>{LASTNAME} - Lastname<br/>{COURSELINK} - Courselink<br/>{OVERVIEWLINK} - Overviewlink';
$string['overviewmailcontent'] = 'Content';
$string['overviewmailcontent_help'] = '<b>Placeholder:</b><br/>{DOCNAME} - Documentname<br/>{COURSELINK} - Courselink<br/>{OVERVIEWLINK} - Overviewlink';

$string['configlabel_first_mail_subject'] = 'Subject first e-mail';
$string['configdesc_first_mail_subject'] = 'Subject template for the first notification e-mail';
$string['configlabel_first_mail_content'] = 'Content first e-mail';
$string['configdesc_first_mail_content'] = 'Content template for first e-mail';

$string['configlabel_second_mail_subject'] = 'Subject further e-mail';
$string['configdesc_second_mail_subject'] = 'Subject template for further notification e-mails';
$string['configlabel_second_mail_content'] = 'Content further e-mails';
$string['configdesc_second_mail_content'] = 'Content template for further e-mails';

$string['configlabel_responsible_mail_subject'] = 'Subject for e-mail to responsible';
$string['configdesc_responsible_mail_subject'] = 'Subject template for e-mail to responsible person';
$string['configlabel_responsible_mail_content'] = 'Content for e-mail to responsible';
$string['configdesc_responsible_mail_content'] = 'Content template for e-mail to responsible person';

$string['configlabel_overview_mail_subject'] = 'Subject overview e-mail';
$string['configdesc_overview_mail_subject'] = 'Subject template for overview e-mail after enddate';
$string['configlabel_overview_mail_content'] = 'Content overview e-mail';
$string['configdesc_overview_mail_content'] = 'Content template for overview e-mail after enddate';

$string['firstmailgroup'] = 'E-Mail template for the first notification e-mail';
$string['secondmailgroup'] = 'E-Mail template for further e-mails';
$string['responsiblemailgroup'] = 'E-Mail template for the responsible person';
$string['overviewmailgroup'] = 'E-Mail template for the overview mail';

$string['notificationperiod'] = 'Notification period';
$string['maxnotifications'] = 'max. notifications';
$string['weekly'] = 'weekly';
$string['fortnight'] = 'fortnight';
$string['monthly'] = 'monthly';

$string['notify-participants'] = 'Inform participants about required document';
$string['messageprovider:notify'] = 'Get message about required document';