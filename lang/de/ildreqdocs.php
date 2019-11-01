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

$string['modulename'] = 'Pflichtdokument';
$string['pluginname'] = 'Pflichtdokument';
$string['pluginadministration'] = 'Pflichtdokument';
$string['modulenameplural'] = 'Pflichtdokumente';
$string['ildreqdocs:addinstance'] = 'Neues Pflichtdokument anlegen';

$string['headerconfig'] = 'Pflichtdokument E-Mail Konfiguration';
$string['descconfig'] = 'Globale Konfiguration der E-Mail Vorlagen für Pflichtdokumente';
$string['configlabel_infotext'] = 'Informationstext';
$string['configdesc_infotext'] = 'Informationstext unterhalb der Aktivität';

$string['mailsubject'] = 'Betreff';
$string['mailsubject_help'] = '<b>Platzhalter:</b><br/>{DOCNAME} - Dokumentname';
$string['mailcontent'] = 'Inhalt';
$string['mailcontent_help'] = '<b>Platzhalter:</b><br/>{DOCNAME} - Dokumentname<br/>{FIRSTNAME} - Vorname<br/>{LASTNAME} - Nachname<br/>{COURSELINK} - Kurslink';
$string['responsiblewmailcontent'] = 'Inhalt';
$string['responsiblemailcontent_help'] = '<b>Platzhalter:</b><br/>{DOCNAME} - Dokumentname<br/>{FIRSTNAME} - Vorname<br/>{LASTNAME} - Nachname<br/>{COURSELINK} - Kurslink<br/>{OVERVIEWLINK} - Übersichtslink';
$string['overviewmailcontent'] = 'Inhalt';
$string['overviewmailcontent_help'] = '<b>Platzhalter:</b><br/>{DOCNAME} - Dokumentname<br/>{COURSELINK} - Kurslink<br/>{OVERVIEWLINK} - Übersichtslink';

$string['configlabel_first_mail_subject'] = 'Betreff erste E-Mail';
$string['configdesc_first_mail_subject'] = 'Betreffsvorlage für die erste Benachrichtigungs-E-Mail';
$string['configlabel_first_mail_content'] = 'Inhalt erste E-Mail';
$string['configdesc_first_mail_content'] = 'Inhaltsvorlage für die erste Benachrichtigungs-E-Mail';

$string['configlabel_second_mail_subject'] = 'Betreff weitere E-Mails';
$string['configdesc_second_mail_subject'] = 'Betreffsvorlage für weitere E-Mails';
$string['configlabel_second_mail_content'] = 'Inhalt weitere E-Mails';
$string['configdesc_second_mail_content'] = 'Inhaltsvorlage weitere Benachrichtigungs-E-Mails';

$string['configlabel_responsible_mail_subject'] = 'Betreff E-Mail an Verantworlichen';
$string['configdesc_responsible_mail_subject'] = 'Betreffsvorlage für E-Mail an den Verantworlichen';
$string['configlabel_responsible_mail_content'] = 'Inhalt E-Mail an Verantworlichen';
$string['configdesc_responsible_mail_content'] = 'Inhaltsvorlage für E-Mail an den Verantworlichen';

$string['configlabel_overview_mail_subject'] = 'Betreff Übersichts-E-Mail';
$string['configdesc_overview_mail_subject'] = 'Betreffsvorlage für Übersichts-E-Mail nach Ablauf des Enddatums';
$string['configlabel_overview_mail_content'] = 'Inhalt Übersichts-E-Mail';
$string['configdesc_overview_mail_content'] = 'Inhaltsvorlage für Übersichts-E-Mail nach Ablauf des Enddatums';

$string['firstmailgroup'] = 'E-Mail Vorlage für die erste Benachrichtigungs-E-Mail';
$string['secondmailgroup'] = 'E-Mail Vorlage für weitere E-Mails';
$string['responsiblemailgroup'] = 'E-Mail Vorlage an den Verantworlichen';
$string['overviewmailgroup'] = 'E-Mail Vorlage für die Übersichts-E-Mail';

$string['notificationperiod'] = 'Benachrichtigungsfrequenz';
$string['maxnotifications'] = 'max. Anzahl Benachrichtigungen';
$string['weekly'] = 'wöchentlich';
$string['fortnight'] = '14-tägig';
$string['monthly'] = 'monatlich';

$string['notify-participants'] = 'Teilnehmer über Pflichtdokument informieren';
$string['messageprovider:notify'] = 'Mitteilung zum Pflichtdokument';