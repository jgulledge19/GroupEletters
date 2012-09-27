<?php
/**
 * Default German Lexicon Entries for GroupELetters
 *
 * @package GroupELetters
 * @subpackage lexicon
 */

//general
$_lang['groupeletters'] = 'GroupELetters';
$_lang['groupeletters.desc'] = 'Newsletter Verwaltung';
$_lang['groupeletters.menu'] = 'Menu';
$_lang['groupeletters.search...'] = 'Suchen...';

//newsletters
$_lang['groupeletters.newsletters'] = 'Newsletter';
$_lang['groupeletters.newsletters.subject'] = 'Betreff';
$_lang['groupeletters.newsletters.date'] = 'Datum';
$_lang['groupeletters.newsletters.document'] = 'Ressource';
$_lang['groupeletters.newsletters.total'] = 'Total';
$_lang['groupeletters.newsletters.sent'] = 'Gesendet';
$_lang['groupeletters.newsletters.new'] = 'Neuer Newsletter';
$_lang['groupeletters.newsletters.groups'] = 'Gruppen';
$_lang['groupeletters.newsletters.remove'] = 'Newsletter entfernen';
$_lang['groupeletters.newsletters.remove.title'] = 'Newsletter entfernen?';
$_lang['groupeletters.newsletters.remove.confirm'] = 'Sind Sie sicher, dass Sie den Newsletter und alle dazugehörigen Daten entfernen wollen?';
$_lang['groupeletters.newsletters.saved'] = 'Newsletter gespeichert (eingeplant)';
$_lang['groupeletters.newsletters.err.save'] = 'Newsletter konnte nicht gespeichert/eingeplant werden.';
$_lang['groupeletters.newsletters.err.nf'] = 'Ressource konnte nicht geöffnet/gefunden werden.';
$_lang['groupeletters.newsletters.err.remove'] = 'Newsletter konnte nicht entfernt werden.';
// Queue
$_lang['groupeletters.queue.ran'] = 'Newsletter-Versand erfolgreich';
$_lang['groupeletters.queue.ran.err'] = 'Newsletter-Versand konnte keine Mails verschicken';

//groups
$_lang['groupeletters.groups'] = 'Gruppen';
$_lang['groupeletters.groups.name'] = 'Name';
$_lang['groupeletters.groups.public'] = 'Öffentlich';
$_lang['groupeletters.groups.public.desc'] = 'Öffentlich (erlaube abonnieren über Formular)';
$_lang['groupeletters.groups.active'] = 'Aktiv';
$_lang['groupeletters.groups.description'] = 'Beschreibung';
$_lang['groupeletters.groups.department'] = 'Abteilung';
$_lang['groupeletters.groups.allow_signup'] = 'Abonnieren erlauben';

$_lang['groupeletters.groups.members'] = 'Abonnenten';
$_lang['groupeletters.groups.new'] = 'Neue Gruppe';
$_lang['groupeletters.groups.edit'] = 'Gruppe Editieren';
$_lang['groupeletters.groups.remove'] = 'Gruppe entfernen';
$_lang['groupeletters.groups.remove.title'] = 'Gruppe entfernen?';
$_lang['groupeletters.groups.remove.confirm'] = 'Sind Sie sicher, dass Sie diese Gruppe entfernen wollen? Abonnenten werden keine gelöscht.';
$_lang['groupeletters.groups.update'] = 'Gruppe bearbeiten';
$_lang['groupeletters.groups.saved'] = 'Gruppe gesichert';
$_lang['groupeletters.groups.err.nf'] = 'Gruppe nicht gefunden';
$_lang['groupeletters.groups.err.save'] = 'Gruppe konnte nicht gespeichert werden.';

//subscribers
$_lang['groupeletters.subscribers'] = 'Abonnenten';
$_lang['groupeletters.subscribers.first_name'] = 'Vorname';
$_lang['groupeletters.subscribers.last_name'] = 'Nachname';
$_lang['groupeletters.subscribers.company'] = 'Firma';
$_lang['groupeletters.subscribers.email'] = 'eMail';
$_lang['groupeletters.subscribers.crm_id'] = 'Kunden ID';
$_lang['groupeletters.subscribers.m_name'] = 'Zweiter Vorname';
$_lang['groupeletters.subscribers.address'] = 'Adresse';
$_lang['groupeletters.subscribers.state'] = 'Kanton';
$_lang['groupeletters.subscribers.zip'] = 'PLZ';
$_lang['groupeletters.subscribers.country'] = 'Land';
$_lang['groupeletters.subscribers.phone'] = 'Telefon';
$_lang['groupeletters.subscribers.cell'] = 'Mobile';
$_lang['groupeletters.subscribers.active'] = 'Aktiv';
$_lang['groupeletters.subscribers.date_created'] = 'Erstellt am';
$_lang['groupeletters.subscribers.code'] = 'Aktivierungscode';


$_lang['groupeletters.subscribers.signupdate'] = 'Abonniert am';
$_lang['groupeletters.subscribers.new'] = 'Neuer Abonnent';
$_lang['groupeletters.subscribers.exportcsv'] = 'Als CSV exportieren';
$_lang['groupeletters.subscribers.importcsv'] = 'CSV Datei importieren';
$_lang['groupeletters.subscribers.importcsv.start'] = 'Import starten';
$_lang['groupeletters.subscribers.importcsv.file'] = 'Datei';
$_lang['groupeletters.subscribers.importcsv.results'] = 'Resultat';
$_lang['groupeletters.subscribers.importcsv.err.uploadfile'] = 'Bitte laden Sie eine Datei hoch.';
$_lang['groupeletters.subscribers.importcsv.err.cantopenfile'] = 'Datei konnte nicht geöffnet werden.';
$_lang['groupeletters.subscribers.importcsv.err.firstrow'] = 'Die erste Zeile muss die Spaltennamen enthalten (die erste Spalte muss "email" heissen)';
$_lang['groupeletters.subscribers.importcsv.err.cantsaverow'] = 'Zeile [[+rownum]] konnte nicht gespeichert werden.';
$_lang['groupeletters.subscribers.importcsv.err.skippedrow'] = 'Zeile [[+rownum]] wurde übersprungen';
$_lang['groupeletters.subscribers.importcsv.msg.complete'] = 'Import komplett. Es wurden [[+importCount]] Einträge importiert ([[+newCount]] neue)';
$_lang['groupeletters.subscribers.confirm.subject'] = 'Bestätigen Sie Ihr Newsletter-Abonnement';
$_lang['groupeletters.subscribers.confirm.success'] = 'Vielen Dank, Sie erhalten jetzt unseren Newsletter.';
$_lang['groupeletters.subscribers.confirm.err'] = 'Abonnent / Code Kombination ist nicht korrekt.';
$_lang['groupeletters.subscribers.signup.err.emailunique'] = 'Diese eMail-Adresse ist bereits registriert.';
$_lang['groupeletters.subscribers.unsubscribe.success'] = 'Sie wurden aus unserer Newsletter-Adressliste gelöscht.';
$_lang['groupeletters.subscribers.unsubscribe.err'] = 'Abonnent konnte nicht gefunden werden.';
$_lang['groupeletters.subscribers.active'] = 'Aktiv';
$_lang['groupeletters.subscribers.groups'] = 'Gruppen';
$_lang['groupeletters.subscribers.remove'] = 'Abonnent entfernen';
$_lang['groupeletters.subscribers.remove.title'] = 'Abonnent entfernen?';
$_lang['groupeletters.subscribers.remove.confirm'] = 'Sind Sie sicher, dass Sie diesen Abonnent entfernen wollen?';
$_lang['groupeletters.subscribers.update'] = 'Abonnent bearbeiten';
$_lang['groupeletters.subscribers.saved'] = 'Abonnent gespeichert';
$_lang['groupeletters.subscribers.err.save'] = 'Beim Speichern des Abonnenten ist ein Fehler aufgetreten';
$_lang['groupeletters.subscribers.err.ae'] = 'Ein Abonnent mit derselben eMail-Adresse existiert bereits.';


//system settings
$_lang['setting_groupeletters.batchSize'] = 'Stapelgrösse';
$_lang['setting_groupeletters.batchSize_desc'] = 'Anzahl versendete eMails pro Stapel. Standardgrösse ist 20.';
$_lang['setting_groupeletters.delay'] = 'Verzögerung';
$_lang['setting_groupeletters.delay_desc'] = 'Der Abstand mit dem die Stapel versendet werden. Standard ist 10 Sekunden.';
$_lang['setting_groupeletters.confirmPageID'] = 'Bestätigungsseite';
$_lang['setting_groupeletters.confirmPageID_desc'] = 'Die ID der Resource für die Newsletter-Bestätigung.';
$_lang['setting_groupeletters.manageSubscriptionsPageID'] = 'Abonnentenverwaltungsseite';
$_lang['setting_groupeletters.manageSubscriptionsPageID_desc'] = 'Die ID der Resource für die Abonnentenverwaltung';
$_lang['setting_groupeletters.unsubscribePageID'] = '"Aus Adressbuch entfernen" Seite';
$_lang['setting_groupeletters.unsubscribePageID_desc'] = 'Die ID der Resource um sich vom Newsletter abzumelden';
// replyEmail, fromEmail, fromName
$_lang['setting_groupeletters.replyEmail'] = 'Antwort eMail-Adresse';
$_lang['setting_groupeletters.replyEmail_desc'] = 'Standardadresse für Antworten';
$_lang['setting_groupeletters.fromEmail'] = 'Absenderadresse';
$_lang['setting_groupeletters.fromEmail_desc'] = 'Standardadresse des Absenders';
$_lang['setting_groupeletters.fromName'] = 'Absendername';
$_lang['setting_groupeletters.fromName_desc'] = 'Standardname des Absenders';



/** Settings - remove these..
$_lang['groupeletters.settings'] = 'Settings';
$_lang['groupeletters.settings.name'] = 'Name';
$_lang['groupeletters.settings.email'] = 'Email';
$_lang['groupeletters.settings.bounceemail'] = 'Bounce email address';
$_lang['groupeletters.settings.template'] = 'Template';
$_lang['groupeletters.settings.saved'] = 'Settings saved';
$_lang['groupeletters.settings.error'] = 'Error while saving settings';
*/