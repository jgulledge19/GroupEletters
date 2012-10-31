<?php
/**
 * Default Czech Lexicon Entries for GroupELetters
 *
 * @package GroupELetters
 * @subpackage lexicon
 */

//general
$_lang['groupeletters'] = 'GroupELetters';
$_lang['groupeletters.desc'] = 'Správce e-mailových newsletterů pro MODX';
$_lang['groupeletters.menu'] = 'Menu';
$_lang['groupeletters.search...'] = 'Hledat...';

//newsletters
$_lang['groupeletters.newsletters'] = 'Newslettery';
$_lang['groupeletters.newsletters.subject'] = 'předmět';
$_lang['groupeletters.newsletters.date'] = 'Datum Od - Do';
$_lang['groupeletters.newsletters.document'] = 'Dokument';
$_lang['groupeletters.newsletters.sent'] = 'Odesláno';
$_lang['groupeletters.newsletters.delivered'] = 'Doručeno';
$_lang['groupeletters.newsletters.bounced'] = 'Zahozeno';
$_lang['groupeletters.newsletters.opened'] = 'Otevřeno/Přečteno';
$_lang['groupeletters.newsletters.clicks'] = 'Odkliknutí';

$_lang['groupeletters.newsletters.new'] = 'Nový newsletter';
$_lang['groupeletters.newsletters.groups'] = 'Skupiny';
$_lang['groupeletters.newsletters.remove'] = 'Odstranit newsletter';
$_lang['groupeletters.newsletters.remove.title'] = 'Odstranit newsletter?';
$_lang['groupeletters.newsletters.remove.confirm'] = 'Opravdu chcete odstranit tento newsletter a všechna jeho data?';
$_lang['groupeletters.newsletters.saved'] = 'Newsletter uložen (naplánován)';
$_lang['groupeletters.newsletters.err.save'] = 'Nemohu uložit/naplánovat newsletter';
$_lang['groupeletters.newsletters.err.nf'] = 'Nemohu otevřít/najít dokument';
$_lang['groupeletters.newsletters.err.remove'] = 'Nemohu odstranit newsletter';
// Queue
$_lang['groupeletters.queue.ran'] = 'Fronta newsletterů proběhla v pořádku';
$_lang['groupeletters.queue.ran.err'] = 'Fronta newsletterů nemůže odeslat e-maily';

//groups
$_lang['groupeletters.groups'] = 'Skupiny';
$_lang['groupeletters.groups.name'] = 'Jméno';
$_lang['groupeletters.groups.public'] = 'Veřejná';
$_lang['groupeletters.groups.public.desc'] = 'Veřejná (odběratelé se mohou přihlásit formulářem)';
$_lang['groupeletters.groups.active'] = 'Aktivní';
$_lang['groupeletters.groups.description'] = 'Popis';
$_lang['groupeletters.groups.department'] = 'Oddělení';
$_lang['groupeletters.groups.allow_signup'] = 'Přihlášení možné';

$_lang['groupeletters.groups.members'] = 'Odběratelé';
$_lang['groupeletters.groups.new'] = 'Nová skupina';
$_lang['groupeletters.groups.edit'] = 'Upravit skupinu';
$_lang['groupeletters.groups.remove'] = 'Odstranit skupinu';
$_lang['groupeletters.groups.remove.title'] = 'Odstranit skupinu?';
$_lang['groupeletters.groups.remove.confirm'] = 'Opravdu chcete odstranit tuto skupinu? Odběratelé nebudou smazáni.';
$_lang['groupeletters.groups.update'] = 'Upravit skupinu';
$_lang['groupeletters.groups.saved'] = 'Skupina uložena';
$_lang['groupeletters.groups.err.nf'] = 'Skupina nenalezena';
$_lang['groupeletters.groups.err.save'] = 'Nemohu uložit skupinu';

//subscribers
$_lang['groupeletters.subscribers.basic_info'] = 'Záklaní informace';
$_lang['groupeletters.subscribers.groups_info'] = 'Skupiny';
$_lang['groupeletters.subscribers.address_info'] = 'Telefon a adresa';
$_lang['groupeletters.subscribers'] = 'Odběratalé';
$_lang['groupeletters.subscribers.first_name'] = 'Jméno';
$_lang['groupeletters.subscribers.m_name'] = 'Další jméno';
$_lang['groupeletters.subscribers.last_name'] = 'Příjmení';
$_lang['groupeletters.subscribers.company'] = 'Společnost';
$_lang['groupeletters.subscribers.email'] = 'E-mail';
$_lang['groupeletters.subscribers.crm_id'] = 'CRM ID';
$_lang['groupeletters.subscribers.address'] = 'Ulice';
$_lang['groupeletters.subscribers.city'] = 'Město/obec';
$_lang['groupeletters.subscribers.state'] = 'Kraj';
$_lang['groupeletters.subscribers.zip'] = 'PSČ';
$_lang['groupeletters.subscribers.country'] = 'Stát';
$_lang['groupeletters.subscribers.phone'] = 'Telefon';
$_lang['groupeletters.subscribers.cell'] = 'Mobilní telefon';
$_lang['groupeletters.subscribers.active'] = 'Aktivní';
$_lang['groupeletters.subscribers.date_created'] = 'Datum vytvoření';
$_lang['groupeletters.subscribers.code'] = 'Vygenerovaný kód';


$_lang['groupeletters.subscribers.signupdate'] = 'Datum přihlášení';
$_lang['groupeletters.subscribers.new'] = 'Nový odběratel';
$_lang['groupeletters.subscribers.exportcsv'] = 'Export CSV';
$_lang['groupeletters.subscribers.importcsv'] = 'Import CSV';
$_lang['groupeletters.subscribers.importcsv.start'] = 'Spustit import';
$_lang['groupeletters.subscribers.importcsv.file'] = 'Soubor';
$_lang['groupeletters.subscribers.importcsv.results'] = 'Výsledky';
$_lang['groupeletters.subscribers.importcsv.err.uploadfile'] = 'Prosím, nahrajte soubor';
$_lang['groupeletters.subscribers.importcsv.err.cantopenfile'] = 'Nemohu otevřít soubor';
$_lang['groupeletters.subscribers.importcsv.err.firstrow'] = 'První řádek musí obsahovat názvy sloupců (první sloupec musí obsahovat e-mail)';
$_lang['groupeletters.subscribers.importcsv.err.cantsaverow'] = 'Nemohu uložit řádek [[+rownum]]';
$_lang['groupeletters.subscribers.importcsv.err.skippedrow'] = 'Řádek [[+rownum]] přeskočen';
$_lang['groupeletters.subscribers.importcsv.msg.complete'] = 'Import dokončen. Importováno [[+importCount]] záznamů ([[+newCount]] nových)';
$_lang['groupeletters.subscribers.confirm.subject'] = 'Potvrďte vaše přihlášení k odběru e-mail newsletteru';
$_lang['groupeletters.subscribers.confirm.success'] = 'Nyní jste přihlášeni k odběru newsletteru.';
$_lang['groupeletters.subscribers.confirm.err'] = 'Chybná kombinace odběratel/kód.';
$_lang['groupeletters.subscribers.signup.err.emailunique'] = 'E-mailová adresa je již přihlášena';
$_lang['groupeletters.subscribers.unsubscribe.success'] = 'Byli jste odhlášeni z odběru newsletteru.';
$_lang['groupeletters.subscribers.unsubscribe.err'] = 'Odběratel nenalezen.';
$_lang['groupeletters.subscribers.active'] = 'Aktivní';
$_lang['groupeletters.subscribers.groups'] = 'Skupiny';
$_lang['groupeletters.subscribers.remove'] = 'Odstranit odběratele';
$_lang['groupeletters.subscribers.remove.title'] = 'Odstranit odběratele?';
$_lang['groupeletters.subscribers.remove.confirm'] = 'Opravdu chcete odstranit odběratele?';
$_lang['groupeletters.subscribers.update'] = 'Upravit odběratele';
$_lang['groupeletters.subscribers.saved'] = 'Odběratel uložen';
$_lang['groupeletters.subscribers.err.save'] = 'Došlo k chybě při ukládání odběratele';
$_lang['groupeletters.subscribers.err.ae'] = 'Odběratel se stejnou e-mailovou adresou již existuje';


//system settings
$_lang['setting_groupeletters.batchSize'] = 'Velikost dávky';
$_lang['setting_groupeletters.batchSize_desc'] = 'Počet e-mailů odeslaných v jedné dávce. Výchozí je 20.';
$_lang['setting_groupeletters.delay'] = 'Prodleva';
$_lang['setting_groupeletters.delay_desc'] = 'Prodleva v sekundách mezi e-maily odeslanými v dávce. Výchozí je 10.';
$_lang['setting_groupeletters.debug'] = 'Ladění';
$_lang['setting_groupeletters.debug_desc'] = 'Pokud je zapnuto, chybový log bude obsahovat ladící informace pro kontrolu chyb.';
$_lang['setting_groupeletters.confirmPageID'] = 'Potvrzovací stránka';
$_lang['setting_groupeletters.confirmPageID_desc'] = 'ID dokumentu pro potvrzení odběrů.';
$_lang['setting_groupeletters.manageSubscriptionsPageID'] = 'Stránka správy odběratelů';
$_lang['setting_groupeletters.manageSubscriptionsPageID_desc'] = 'ID dokumentu pro správu odběratelů';
$_lang['setting_groupeletters.unsubscribePageID'] = 'Odhlašovací stránka';
$_lang['setting_groupeletters.unsubscribePageID_desc'] = 'ID dokumentu stránky pro odhlášení';
$_lang['setting_groupeletters.trackingPageID'] = 'Přesměrovací stránka';
$_lang['setting_groupeletters.trackingPageID_desc'] = 'ID dokumentu s přesměrováním pro sledování odkliků newsletteru';
$_lang['setting_groupeletters.useUrlTracking'] = 'Používat sledování odkliků';
$_lang['setting_groupeletters.useUrlTracking_desc'] = 'Zapněte na true pro aktivaci sledování odkliků newsletteru';

// replyEmail, fromEmail, fromName
$_lang['setting_groupeletters.replyEmail'] = 'E-mail pro odpovědi';
$_lang['setting_groupeletters.replyEmail_desc'] = 'Výchozí e-mail pro odpovědi';
$_lang['setting_groupeletters.fromEmail'] = 'E-mail odesílatel';
$_lang['setting_groupeletters.fromEmail_desc'] = 'Výchozí e-mailová adresa odesílatele';
$_lang['setting_groupeletters.fromName'] = 'Jméno odesílatek';
$_lang['setting_groupeletters.fromName_desc'] = 'Výchozí jméno odesílatele';



/** Settings - remove these..
$_lang['groupeletters.settings'] = 'Settings';
$_lang['groupeletters.settings.name'] = 'Name';
$_lang['groupeletters.settings.email'] = 'Email';
$_lang['groupeletters.settings.bounceemail'] = 'Bounce email address';
$_lang['groupeletters.settings.template'] = 'Template';
$_lang['groupeletters.settings.saved'] = 'Settings saved';
$_lang['groupeletters.settings.error'] = 'Error while saving settings';
*/