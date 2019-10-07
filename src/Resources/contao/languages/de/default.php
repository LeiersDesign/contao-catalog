<?php

/**
 * Portal
 */
$GLOBALS['TL_LANG']['MOD']['portal'] = 'Unternehmensportal';
$GLOBALS['TL_LANG']['MOD']['unternehmen'] = array('Unternehmens-Verzeichnis', 'Firmeneinträge verwalten');
$GLOBALS['TL_LANG']['MOD']['benutzer'] = array('Firmenbenutzer', 'Firmenbenutzer verwalten');
$GLOBALS['TL_LANG']['MOD']['benutzerpakete'] = array('Benutzerpakete', 'Benutzerpakete verwalten');

/**
 * Taxonomie
 */
$GLOBALS['TL_LANG']['MOD']['taxonomie'] = 'Taxonomie';
$GLOBALS['TL_LANG']['MOD']['staedte'] = array('Städte & Stadteile', 'Städte & Stadteile verwalten');
$GLOBALS['TL_LANG']['MOD']['kategorien'] = array('Kategorien', 'Kategorien verwalten');
$GLOBALS['TL_LANG']['MOD']['branchen'] = array('Branchen', 'Branchen verwalten');
$GLOBALS['TL_LANG']['MOD']['lebenslagen'] = array('Lebenslagen', 'Branchen verwalten');

/**
 * Label
 */
$GLOBALS['TL_LANG']['MSC']['tl_stadte_label']['staedte'] = ' Stadtteile & ';
$GLOBALS['TL_LANG']['MSC']['tl_stadte_label']['gewerbegebiete'] = ' Gewerbegebiete hinterlegt';

/**
 * Optionen
 */
//Stadtteile & Gewerbegebiete
$GLOBALS['TL_LANG']['MSC']['no_district'] = 'kein Stadtteil zugeordnet';
$GLOBALS['TL_LANG']['MSC']['no_commercial_area'] = 'kein Gewerbegebiet zugeordnet';

//Firmen-Events
$GLOBALS['TL_LANG']['MSC']['tl_firmen_events']['event'] = 'Veranstaltung';
$GLOBALS['TL_LANG']['MSC']['tl_firmen_events']['news'] = 'News (Aktuelles-Eintrag)';

/**
 * Versions Unterschiede
 */
$GLOBALS['TL_LANG']['MSC']['version_diffs']['id'] = "ID";
$GLOBALS['TL_LANG']['MSC']['version_diffs']['tstamp'] = "zuletzt geändert";
$GLOBALS['TL_LANG']['MSC']['version_diffs']['name'] = $GLOBALS['TL_LANG']['tl_firmen']['name'];

//Werte nicht definiert
$GLOBALS['TL_LANG']['MSC']['version_diffs']['yes'] = "Ja";
$GLOBALS['TL_LANG']['MSC']['version_diffs']['no'] = "Nein";
$GLOBALS['TL_LANG']['MSC']['version_diffs']['confirm_version_switch'] = "Sind Sie sicher, dass Sie die neue Version aktivieren möchen?";
$GLOBALS['TL_LANG']['MSC']['version_diffs']['kein_bild'] = "<i>-kein Bild hinzugefügt-</i>";
$GLOBALS['TL_LANG']['MSC']['version_diffs']['keine_kategorie'] = "<i>-Keine Kategorie zugeordnet-</i>";
$GLOBALS['TL_LANG']['MSC']['version_diffs']['keine_lebenslage'] = "<i>-Keine Lebenslage zugeordnet-</i>";
$GLOBALS['TL_LANG']['MSC']['version_diffs']['keine_branche'] = "<i>-Keine Branche zugeordnet-</i>";

/**
 * Module
 */
$GLOBALS['TL_LANG']['MSC']['catalog']['modules']['list_user_companies'] = "Auflistung der Unternehmen des Benutzers";
$GLOBALS['TL_LANG']['MSC']['catalog']['modules']['toggle_user_company'] = "Unternehmen des Benutzers (un-)sichtbar schalten";
$GLOBALS['TL_LANG']['MSC']['catalog']['modules']['company_preview'] = "Vorschau eines Eintrags";
$GLOBALS['TL_LANG']['MSC']['catalog']['modules']['company_edit'] = "Bearbeiten eines Eintrags";

/**
 * Content Elements
 */
$GLOBALS['TL_LANG']['MSC']['catalog']['modules']['list_single_company'] = "Einzelner Eintrag: <b><i>%s</i></b>";
$GLOBALS['TL_LANG']['MSC']['catalog']['modules']['overview_map'] = "Übersichtskarte";

/**
 * Backend
 */
$GLOBALS['TL_LANG']['MSC']['catalog']['BE']['firmen_label']['request_update'] = "Freischaltung erwartet";
        
/**
 * Frontend Nachrichten
 */
$GLOBALS['TL_LANG']['MSC']['catalog']['FE']['no_company'] = "Sie haben noch kein Unternehmen eingetragen.";

/**
 * Frontend Bezeichnungen
 */
$GLOBALS['TL_LANG']['MSC']['catalog']['FE']['names']['facebook'] = "Facebook";
$GLOBALS['TL_LANG']['MSC']['catalog']['FE']['names']['twitter'] = "Twitter";
$GLOBALS['TL_LANG']['MSC']['catalog']['FE']['names']['instagram'] = "Instagram";
$GLOBALS['TL_LANG']['MSC']['catalog']['FE']['names']['xing'] = "XING";
$GLOBALS['TL_LANG']['MSC']['catalog']['FE']['names']['gplus'] = "Google-Plus";

$GLOBALS['TL_LANG']['MSC']['catalog']['FE']['actions']['label'] = 'Aktionen';
$GLOBALS['TL_LANG']['MSC']['catalog']['FE']['actions']['edit'] = 'Eintrag bearbeiten';
$GLOBALS['TL_LANG']['MSC']['catalog']['FE']['actions']['delete'] = 'Eintrag bearbeiten';
$GLOBALS['TL_LANG']['MSC']['catalog']['FE']['actions']['preview'] = 'Vorschau anzeigen';
$GLOBALS['TL_LANG']['MSC']['catalog']['FE']['actions']['toggle'] = array('Eintrag im Portal veröffentlichen (aktuell nicht für andere sichtbar)', 'Eintrag im Portal verstecken (aktuell für andere sichtbar)');

$GLOBALS['TL_LANG']['MSC']['catalog']['FE']['labels']['branchen'] = array('Branche: ', 'Branchen: ');
$GLOBALS['TL_LANG']['MSC']['catalog']['FE']['labels']['kategorien'] = array('Kategorie: ', 'Kategorien: ');
$GLOBALS['TL_LANG']['MSC']['catalog']['FE']['labels']['imperssions'] = "Impressionen";
$GLOBALS['TL_LANG']['MSC']['catalog']['FE']['labels']['description'] = "Das sind wir";


$GLOBALS['TL_LANG']['MSC']['catalog']['FE']['labels']['detailLink'] = "<a href='%s' title='zur Detailseite des Eintrags %s'><i class='fa fa-angle-double-right'></i>Unternehmen im Detail ansehen</a>";

$GLOBALS['TL_LANG']['MSC']['catalog']['FE']['alerts']['label'] = 'Status';
$GLOBALS['TL_LANG']['MSC']['catalog']['FE']['alerts']['published'][0] = 'Eintrag ist im Portal sichtbar';
$GLOBALS['TL_LANG']['MSC']['catalog']['FE']['alerts']['published'][1] = 'Eintrag ist nicht im Portal sichtbar.';

$GLOBALS['TL_LANG']['MSC']['catalog']['FE']['alerts']['request_update'][0] = 'Eintrag hat keine Änderungen, die noch nicht eingereicht wurden.';
$GLOBALS['TL_LANG']['MSC']['catalog']['FE']['alerts']['request_update'][1] = 'Eintrag hat Änderungen, die noch nicht eingereicht wurden.';

$GLOBALS['TL_LANG']['MSC']['catalog']['FE']['alerts']['request_publish'] = 'Die initiale Version des Eintrags wurde nocht nicht veröffentlicht.';

$GLOBALS['TL_LANG']['MSC']['catalog']['FE']['alerts']['is_versioned'][0] = '<p class="catalog-info">So sehen Nutzer Ihr Unternehmen.</p>';
$GLOBALS['TL_LANG']['MSC']['catalog']['FE']['alerts']['is_versioned'][1] = '<p class="catalog-info">Ihr Unternehmen hat Änderungen, welche Sie noch nicht an den Betreiber zur Freischaltung eingereicht haben.<br>'
        . 'Das heißt nur Sie können aktuell die letzten Änderungen an Ihrem Unternehmen sehen.</p>';

$GLOBALS['TL_LANG']['MSC']['catalog']['FE']['results']['company_not_found'] = 'Das Unternehmen wurde nicht gefunden.';
$GLOBALS['TL_LANG']['MSC']['catalog']['FE']['results']['no_rights'] = 'Sie haben keine Befugnis diesen Eintrag zu barbeiten.';

$GLOBALS['TL_LANG']['MSC']['catalog']['FE']['results']['company_hidden'] = 'Das Unternehmen %s wird nun nicht mehr im Portal angezeigt.';
$GLOBALS['TL_LANG']['MSC']['catalog']['FE']['results']['company_shown'] = 'Das Unternehmen %s wird nun im Portal angezeigt.';

$GLOBALS['TL_LANG']['MSC']['catalog']['FE']['results']['back_link'] = '<p class="back"><a href="%s">zurück</a></p>';


/**
 * Formulare
 */
$GLOBALS['TL_LANG']['MSC']['catalog']['FE']['forms']['buttons']['form_submit'] = 'Speichern & zur Freischaltung einreichen';
$GLOBALS['TL_LANG']['MSC']['catalog']['FE']['forms']['buttons']['form_submit'] = 'Speichern & zur Freischaltung einreichen';
$GLOBALS['TL_LANG']['MSC']['catalog']['FE']['forms']['buttons']['form_save'] = 'Speichern & für spätere Bearbeitung merken';

$GLOBALS['TL_LANG']['MSC']['catalog']['FE']['forms']['labels']['name'] = "Name";
$GLOBALS['TL_LANG']['MSC']['catalog']['FE']['forms']['labels']['zusatz'] = "Firmenzusatz";
