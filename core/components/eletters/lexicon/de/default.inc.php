<?php
/**
 * Default German Lexicon Entries for ELetters
 *
 * @package ELetters
 * @subpackage lexicon
 */

//general
$_lang['eletters'] = 'ELetters';
$_lang['eletters.desc'] = 'Newsletter Verwaltung';
$_lang['eletters.menu'] = 'Menu';
$_lang['eletters.search...'] = 'Suchen...';

//newsletters
$_lang['eletters.newsletters'] = 'Newsletter';
$_lang['eletters.newsletters.subject'] = 'Betreff';
$_lang['eletters.newsletters.date'] = 'Datum';
$_lang['eletters.newsletters.document'] = 'Ressource';
$_lang['eletters.newsletters.total'] = 'Total';
$_lang['eletters.newsletters.sent'] = 'Gesendet';
$_lang['eletters.newsletters.new'] = 'Neuer Newsletter';
$_lang['eletters.newsletters.groups'] = 'Gruppen';
$_lang['eletters.newsletters.remove'] = 'Newsletter entfernen';
$_lang['eletters.newsletters.remove.title'] = 'Newsletter entfernen?';
$_lang['eletters.newsletters.remove.confirm'] = 'Sind Sie sicher, dass Sie den Newsletter und alle dazugehörigen Daten entfernen wollen?';
$_lang['eletters.newsletters.saved'] = 'Newsletter gespeichert (eingeplant)';
$_lang['eletters.newsletters.err.save'] = 'Newsletter konnte nicht gespeichert/eingeplant werden.';
$_lang['eletters.newsletters.err.nf'] = 'Ressource konnte nicht geöffnet/gefunden werden.';
$_lang['eletters.newsletters.err.remove'] = 'Newsletter konnte nicht entfernt werden.';
// Queue
$_lang['eletters.queue.ran'] = 'Newsletter-Versand erfolgreich';
$_lang['eletters.queue.ran.err'] = 'Newsletter-Versand konnte keine Mails verschicken';

//groups
$_lang['eletters.groups'] = 'Gruppen';
$_lang['eletters.groups.name'] = 'Name';
$_lang['eletters.groups.public'] = 'Öffentlich';
$_lang['eletters.groups.public.desc'] = 'Öffentlich (erlaube abonnieren über Formular)';
$_lang['eletters.groups.active'] = 'Aktiv';
$_lang['eletters.groups.description'] = 'Beschreibung';
$_lang['eletters.groups.department'] = 'Abteilung';
$_lang['eletters.groups.allow_signup'] = 'Abonnieren erlauben';

$_lang['eletters.groups.members'] = 'Abonnenten';
$_lang['eletters.groups.new'] = 'Neue Gruppe';
$_lang['eletters.groups.edit'] = 'Gruppe Editieren';
$_lang['eletters.groups.remove'] = 'Gruppe entfernen';
$_lang['eletters.groups.remove.title'] = 'Gruppe entfernen?';
$_lang['eletters.groups.remove.confirm'] = 'Sind Sie sicher, dass Sie diese Gruppe entfernen wollen? Abonnenten werden keine gelöscht.';
$_lang['eletters.groups.update'] = 'Gruppe bearbeiten';
$_lang['eletters.groups.saved'] = 'Gruppe gesichert';
$_lang['eletters.groups.err.nf'] = 'Gruppe nicht gefunden';
$_lang['eletters.groups.err.save'] = 'Gruppe konnte nicht gespeichert werden.';

//subscribers
$_lang['eletters.subscribers.basic_info'] = 'Basisinfos';
$_lang['eletters.subscribers.groups_info'] = 'Gruppeninfos';
$_lang['eletters.subscribers.address_info'] = 'Telefon &amp; Adresse';
$_lang['eletters.subscribers'] = 'Abonnenten';
$_lang['eletters.subscribers.first_name'] = 'Vorname';
$_lang['eletters.subscribers.m_name'] = 'Zweiter Vorname';
$_lang['eletters.subscribers.last_name'] = 'Nachname';
$_lang['eletters.subscribers.company'] = 'Firma';
$_lang['eletters.subscribers.email'] = 'eMail';
$_lang['eletters.subscribers.crm_id'] = 'Kunden ID';
$_lang['eletters.subscribers.address'] = 'Adresse';
$_lang['eletters.subscribers.city'] = 'Ort';
$_lang['eletters.subscribers.state'] = 'Bundesstaat/Kanton';
$_lang['eletters.subscribers.zip'] = 'PLZ';
$_lang['eletters.subscribers.country'] = 'Land';
$_lang['eletters.subscribers.phone'] = 'Telefon';
$_lang['eletters.subscribers.cell'] = 'Mobile';
$_lang['eletters.subscribers.active'] = 'Aktiv';
$_lang['eletters.subscribers.date_created'] = 'Erstellt am';
$_lang['eletters.subscribers.code'] = 'Aktivierungscode';


$_lang['eletters.subscribers.signupdate'] = 'Abonniert am';
$_lang['eletters.subscribers.new'] = 'Neuer Abonnent';
$_lang['eletters.subscribers.exportcsv'] = 'Als CSV exportieren';
$_lang['eletters.subscribers.importcsv'] = 'CSV Datei importieren';
$_lang['eletters.subscribers.importcsv.start'] = 'Import starten';
$_lang['eletters.subscribers.importcsv.file'] = 'Datei';
$_lang['eletters.subscribers.importcsv.results'] = 'Resultat';
$_lang['eletters.subscribers.importcsv.err.uploadfile'] = 'Bitte laden Sie eine Datei hoch.';
$_lang['eletters.subscribers.importcsv.err.cantopenfile'] = 'Datei konnte nicht geöffnet werden.';
$_lang['eletters.subscribers.importcsv.err.firstrow'] = 'Die erste Zeile muss die Spaltennamen enthalten (die erste Spalte muss "email" heissen)';
$_lang['eletters.subscribers.importcsv.err.cantsaverow'] = 'Zeile [[+rownum]] konnte nicht gespeichert werden.';
$_lang['eletters.subscribers.importcsv.err.skippedrow'] = 'Zeile [[+rownum]] wurde übersprungen';
$_lang['eletters.subscribers.importcsv.msg.complete'] = 'Import komplett. Es wurden [[+importCount]] Einträge importiert ([[+newCount]] neue)';
$_lang['eletters.subscribers.confirm.subject'] = 'Bestätigen Sie Ihr Newsletter-Abonnement';
$_lang['eletters.subscribers.confirm.success'] = 'Vielen Dank, Sie erhalten jetzt unseren Newsletter.';
$_lang['eletters.subscribers.confirm.err'] = 'Abonnent / Code Kombination ist nicht korrekt.';
$_lang['eletters.subscribers.signup.err.emailunique'] = 'Diese eMail-Adresse ist bereits registriert.';
$_lang['eletters.subscribers.unsubscribe.success'] = 'Sie wurden aus unserer Newsletter-Adressliste gelöscht.';
$_lang['eletters.subscribers.unsubscribe.err'] = 'Abonnent konnte nicht gefunden werden.';
$_lang['eletters.subscribers.active'] = 'Aktiv';
$_lang['eletters.subscribers.groups'] = 'Gruppen';
$_lang['eletters.subscribers.remove'] = 'Abonnent entfernen';
$_lang['eletters.subscribers.remove.title'] = 'Abonnent entfernen?';
$_lang['eletters.subscribers.remove.confirm'] = 'Sind Sie sicher, dass Sie diesen Abonnent entfernen wollen?';
$_lang['eletters.subscribers.update'] = 'Abonnent bearbeiten';
$_lang['eletters.subscribers.saved'] = 'Abonnent gespeichert';
$_lang['eletters.subscribers.err.save'] = 'Beim Speichern des Abonnenten ist ein Fehler aufgetreten';
$_lang['eletters.subscribers.err.ae'] = 'Ein Abonnent mit derselben eMail-Adresse existiert bereits.';


//system settings
$_lang['setting_eletters.batchSize'] = 'Stapelgrösse';
$_lang['setting_eletters.batchSize_desc'] = 'Anzahl versendete eMails pro Stapel. Standardgrösse ist 20.';
$_lang['setting_eletters.delay'] = 'Verzögerung';
$_lang['setting_eletters.delay_desc'] = 'Der Abstand mit dem die Stapel versendet werden. Standard ist 10 Sekunden.';
$_lang['setting_eletters.confirmPageID'] = 'Bestätigungsseite';
$_lang['setting_eletters.confirmPageID_desc'] = 'Die ID der Resource für die Newsletter-Bestätigung.';
$_lang['setting_eletters.manageSubscriptionsPageID'] = 'Abonnentenverwaltungsseite';
$_lang['setting_eletters.manageSubscriptionsPageID_desc'] = 'Die ID der Resource für die Abonnentenverwaltung';
$_lang['setting_eletters.unsubscribePageID'] = '"Aus Adressbuch entfernen" Seite';
$_lang['setting_eletters.unsubscribePageID_desc'] = 'Die ID der Resource um sich vom Newsletter abzumelden';
// replyEmail, fromEmail, fromName
$_lang['setting_eletters.replyEmail'] = 'Antwort eMail-Adresse';
$_lang['setting_eletters.replyEmail_desc'] = 'Standardadresse für Antworten';
$_lang['setting_eletters.fromEmail'] = 'Absenderadresse';
$_lang['setting_eletters.fromEmail_desc'] = 'Standardadresse des Absenders';
$_lang['setting_eletters.fromName'] = 'Absendername';
$_lang['setting_eletters.fromName_desc'] = 'Standardname des Absenders';



/** Settings - remove these..
$_lang['eletters.settings'] = 'Settings';
$_lang['eletters.settings.name'] = 'Name';
$_lang['eletters.settings.email'] = 'Email';
$_lang['eletters.settings.bounceemail'] = 'Bounce email address';
$_lang['eletters.settings.template'] = 'Template';
$_lang['eletters.settings.saved'] = 'Settings saved';
$_lang['eletters.settings.error'] = 'Error while saving settings';
*/