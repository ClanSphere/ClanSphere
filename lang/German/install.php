<?php
// ClanSphere 2010 - www.clansphere.net
// $Id$

$cs_lang['mod_name']  = 'Installation';
$cs_lang['modtext']  = 'Richtet das Portalsystem ein';

$cs_lang['head_list']  = 'Liste';
$cs_lang['body_list']  = 'Willkommen bei der Installation von ClanSphere!' . cs_html_br(2) . 'Bitte w&auml;hlen Sie eine Sprache:';

$cs_lang['lang'] = 'Sprache';

$cs_lang['language_choose'] = 'Sprachauswahl';
$cs_lang['install_check'] = 'Installationspr&uuml;fung';
$cs_lang['license'] = 'Lizenz';
$cs_lang['configuration'] = 'Konfiguration';
$cs_lang['database'] = 'Datenbank';
$cs_lang['login'] = 'Login';

$cs_lang['this_is_compatible_check'] = 'Hier wird gepr&uuml;ft, ob sich der Webserver f&uuml;r die Installation von ClanSphere eignet.';
$cs_lang['enough'] = 'Ausreichend';
$cs_lang['compatible_database'] = 'Kompatible Datenbank';
$cs_lang['change'] = 'Wechseln';
$cs_lang['create_admin_head'] = 'Webmaster anlegen';
$cs_lang['last_check'] = 'Letzte &Uuml;berpr&uuml;fung';

$cs_lang['check'] = 'Pr&uuml;fung';
$cs_lang['found'] = 'Vorhanden';
$cs_lang['required'] = 'Ben&ouml;tigt';
$cs_lang['any']  = 'Irgendeine';
$cs_lang['recommend'] = 'Empfohlen';
$cs_lang['php_mod']  = 'PHP Modul';
$cs_lang['db_support']  = 'Datenbankunterst&uuml;tzung';
$cs_lang['short_open_tag'] = 'PHP wie XML &ouml;ffnen';
$cs_lang['file_uploads'] = 'Dateien hochladen';
$cs_lang['reg_global'] = 'Globale Registrierung';
$cs_lang['magic_quotes'] = 'Magische Anf&uuml;hrungszeichen';
$cs_lang['safe_mode'] = 'Sicherer Modus';
$cs_lang['trans_sid'] = 'Transparente SessionID';
$cs_lang['basedir_restriction'] = 'Abgesicherte Pfadumgebung';
$cs_lang['allow_url_fopen'] = 'Externe Inhalte laden';
$cs_lang['allow_url_include'] = 'Externe Inhalte ausf&uuml;hren';
$cs_lang['gd_extension'] = 'GD Erweiterung';
$cs_lang['off']  = 'aus';
$cs_lang['on'] = 'an';

$cs_lang['check_perfect'] = 'Die gepr&uuml;ften Einstellungen sind perfekt f&uuml;r die Benutzung von ClanSphere!';
$cs_lang['check_ok'] = 'ClanSphere sollte auf diesem Webserver einwandfrei funktionieren, allerdings sind einige Einstellungen nicht optimal.';
$cs_lang['check_failed'] = 'Aufgrund der oben markierten Gr&uuml;nde ist es leider nicht m&ouml;glich, ClanSphere zu installieren!';

$cs_lang['head_complete']  = 'Ende';
$cs_lang['rem_install']  = '- Installations-Dateien werden entfernt';
$cs_lang['set_chmod']  = '- Verzeichnisse erhalten neue Rechte';
$cs_lang['remove_file'] = 'Datei bitte manuell entfernen:';
$cs_lang['err_chmod']  = 'Fehler: Setzen Sie die Rechte des Verzeichnisses "uploads",';
$cs_lang['err_chmod']  .= ' sowie dessen Unterverzeichnisse, bitte Manuell auf CHMOD 777';

$cs_lang['login']  = 'Login';

$cs_lang['head_license']  = 'Lizenz';
$cs_lang['body_license']  = 'Akzeptieren der Nutzungsbedingungen';

$cs_lang['accept_done'] = 'Bedingungen erfolgreich akzeptiert';
$cs_lang['accept_license'] = 'Gelesen und akzeptiert';
$cs_lang['not_accepted'] = '- Sie m&uuml;ssen den Bedingungen zustimmen';
$cs_lang['send'] = 'Senden';

$cs_lang['head_settings']  = 'Konfiguration';
$cs_lang['body_settings']  = 'Erstellung einer Setup Datei f&uuml;r das Portal';

$cs_lang['hash'] = 'Verschl&uuml;sselung';
$cs_lang['hash_info'] = 'Sha1 wird empfohlen';
$cs_lang['type'] = 'Datenbank Typ';
$cs_lang['type_info'] = 'Meistens ist dies MySQL (mysql)';
$cs_lang['subtype'] = 'Datenbank Speicherungstyp';
$cs_lang['subtype_info'] = 'Nur bei MySQL! Verwendet myisam wenn leer gelassen';
$cs_lang['place'] = 'Ort der Datenbank';
$cs_lang['place_info'] = 'Angabe von IP, DNS, oder nichts bei UNIX Domain Socket';
$cs_lang['sqlite_info'] = 'Bei SQLite gesch&uuml;tzten Pfad mit Dateinamen angeben';
$cs_lang['user'] = 'Benutzer (Datenbank)';
$cs_lang['pwd'] = 'Passwort (Datenbank)';
$cs_lang['db_name'] = 'Name der Datenbank';
$cs_lang['prefix'] = 'Tabellen Pr&auml;fix';
$cs_lang['more'] = 'Erweitert';
$cs_lang['save_actions'] = ' Datenbank-Aktionen protokollieren';
$cs_lang['save_errors'] = ' Bekannte Portal-Fehler protokollieren';
$cs_lang['charset'] = 'Zeichensatz';

$cs_lang['no_hash'] = '- Es muss eine Verschl&uuml;sselung ausgew&auml;hlt werden';
$cs_lang['no_type'] = '- Es muss ein Datenbank Server ausgew&auml;hlt werden';
$cs_lang['no_name'] = '- Der Name darf nicht Leer sein';
$cs_lang['prefix_err'] = '- Im Pr&auml;fix sind keine oder unerlaubte Zeichen';
$cs_lang['db_err'] = '- DB Fehler:';
$cs_lang['file_err'] = '- Setup Datei muss per "Anzeigen" manuell hochgeladen werden';

$cs_lang['save_file'] = 'Den Inhalt bitte kopieren und als "setup.php" auf dem Webspace im ClanSphere-Verzeichnis abspeichern, wo auch die "index.php" liegt. Im Anschluss diese Seite neu Laden oder Installation neu starten!';

$cs_lang['setup_exists'] = 'Es wurde eine bestehende Setup Datei gefunden.';
$cs_lang['inst_create_done'] = 'Datenbank gefunden und Setup Datei erstellt.';

$cs_lang['head_sql']  = 'Datenbank';
$cs_lang['body_sql']  = 'Tabellen und Eintr&auml;ge werden angelegt';

$cs_lang['create_admin']  = 'Hier wird ein Administratorkonto erstellt.';
$cs_lang['nick']  = 'Nick';
$cs_lang['email']  = 'E-Mail';
$cs_lang['password'] = 'Passwort';
$cs_lang['admin_done'] = 'Administrator erfolgreich hinzugef&uuml;gt.';

$cs_lang['short_nick'] = '- Der Nick ist zu kurz (min. 4)';
$cs_lang['short_pwd'] = '- Das Passwort ist zu kurz (min. 4)';
$cs_lang['email_false'] = '- Die E-Mail-Adresse ist ung&uuml;ltig';

$cs_lang['db_error'] = 'Datenbank Fehler';
$cs_lang['remove_and_again'] = 'Erstellte Inhalte entfernen und neuen Versuch starten';

$cs_lang['guest']  = 'Besucher';
$cs_lang['community']  = 'Benutzer';
$cs_lang['member']  = 'Mitglied';
$cs_lang['orga']  = 'Organisator';
$cs_lang['admin']  = 'Webmaster';

// Labels
$cs_lang['show_groups_as'] = 'Zeige Gruppen als';

$cs_lang['clan'] = 'Clan';
$cs_lang['association'] = 'Verein';
$cs_lang['club'] = 'Club';
$cs_lang['guild'] = 'Gilde';
$cs_lang['enterprise'] = 'Firma';
$cs_lang['school'] = 'Schule';

$cs_lang['show_subgroups_as'] = 'Zeige Untergruppen als';

$cs_lang['squads'] = 'Squads';
$cs_lang['groups'] = 'Gruppen';
$cs_lang['sections'] = 'Abteilungen';
$cs_lang['teams'] = 'Teams';
$cs_lang['class'] = 'Klassen';

$cs_lang['show_members_as'] = 'Zeige Mitglieder als';

$cs_lang['members'] = 'Mitglieder';
$cs_lang['employees'] = 'Mitarbeiter';
$cs_lang['teammates'] = 'Mitspieler';
$cs_lang['classmates'] = 'Mitsch&uuml;ler';

$cs_lang['mark_all'] = 'Alle markieren';
$cs_lang['unmark_all'] = 'Alle demarkieren';

$cs_lang['database_modselect'] = 'Datenbank &raquo; Module ausw&auml;hlen';
$cs_lang['full_install'] = 'Komplettinstallation';
$cs_lang['module_select'] = 'Module ausw&auml;hlen';
$cs_lang['select_module'] = 'Bitte w&auml;hlen Sie die zu installierenden Module aus';
$cs_lang['sys_module'] = 'System Module';
$cs_lang['opt_module'] = 'Optionale Module';
$cs_lang['install'] = 'Installieren';
$cs_lang['abcode'] = 'Abcode';
$cs_lang['access'] = 'Zugriff';
$cs_lang['article'] = 'Artikel';
$cs_lang['awards'] = 'Erreichte Platzierungen';
$cs_lang['banner'] = 'Banner';
$cs_lang['board'] = 'Forum';
$cs_lang['boardmods'] = 'Forummods';
$cs_lang['boardranks'] = 'Forumr&auml;nge';
$cs_lang['buddys'] = 'Freunde';
$cs_lang['captcha'] = 'Sicherheitscodes';
$cs_lang['cash'] = 'Finanzen';
$cs_lang['categories'] = 'Kategorien';
$cs_lang['clans'] = 'Clans';
$cs_lang['clansphere'] = 'ClanSphere';
$cs_lang['comments'] = 'Kommentare';
$cs_lang['computers'] = 'Computer';
$cs_lang['contact'] = 'Kontakt';
$cs_lang['count'] = 'Besucher / Counter';
$cs_lang['errors'] = 'Fehler';
$cs_lang['events'] = 'Termine';
$cs_lang['explorer'] = 'Explorer';
$cs_lang['faq'] = 'H&auml;ufige Fragen / F.A.Q.';
$cs_lang['ckeditor'] = 'WYSIWYG CKeditor';
$cs_lang['fightus'] = 'Fightus';
$cs_lang['files'] = 'Downloads';
$cs_lang['gallery'] = 'Gallery';
$cs_lang['games'] = 'Spiele';
$cs_lang['gbook'] = 'G&auml;stebuch';
$cs_lang['history'] = 'Geschichte';
$cs_lang['joinus'] = 'Joinus';
$cs_lang['links'] = 'Links';
$cs_lang['linkus'] = 'Link us';
$cs_lang['logs'] = 'Logs';
$cs_lang['maps'] = 'Karten';
$cs_lang['members'] = 'Mitglieder';
$cs_lang['messages'] = 'Nachrichten';
$cs_lang['modules'] = 'Module';
$cs_lang['news'] = 'News';
$cs_lang['newsletter'] = 'Newsletter';
$cs_lang['options'] = 'Optionen';
$cs_lang['partner'] = 'Partner';
$cs_lang['quotes'] = 'Zitate';
$cs_lang['ranks'] = 'Ranglisten';
$cs_lang['replays'] = 'Wiederholungen';
$cs_lang['rules'] = 'Regeln';
$cs_lang['search'] = 'Suche';
$cs_lang['servers'] = 'Server';
$cs_lang['shoutbox'] = 'Shoutbox';
$cs_lang['squads'] = 'Squads';
$cs_lang['static'] = 'Statische Seiten';
$cs_lang['updates'] = 'Updates';
$cs_lang['users'] = 'Benutzer';
$cs_lang['usersgallery'] = 'Benutzergallery';
$cs_lang['votes'] = 'Umfragen';
$cs_lang['wars'] = 'Clanwars';
$cs_lang['wizard'] = 'Installations Assistent';
$cs_lang['clansphere_core'] = 'ClanSphere Basis';
$cs_lang['metatags'] = 'Metatags';